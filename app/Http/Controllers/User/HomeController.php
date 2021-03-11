<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FacebookStreaming;
use App\Models\Greeting;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('revalidate');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $user->is_first_login = false;
        $user->save();

        $save_path = public_path() . '/images/ID/card_' . $user->id . '.jpg';
        if (File::exists($save_path))
        {
            File::delete($save_path);
        }

        $date_today_start = date('Y-m-d');
        $date_today_end = date('Y-m-d');
        $date_today_end = date('Y-m-d', strtotime($date_today_end . '+1 days'));
        
        $greetings = Greeting::whereBetween('display_date', [$date_today_start, $date_today_end])->get();

        $streaming = FacebookStreaming::first();

        return view('user.home', compact('greetings', 'streaming'));
    }

    /**
     * Handle a user good condition request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function mabutiStatus(Request $request)
    {
        $user = Auth::user();
        $user->is_status_answered = true;
        $user->save();

        if ($user != null)
        {
            $status = new Status();
            $status->user_id = $user->id;
            $status->is_okay = true;
            $status->save();
            return redirect()->back();
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }
}
