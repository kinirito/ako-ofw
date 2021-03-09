<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\EmbedYoutubeLiveStreaming;
use App\Models\Greeting;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
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

        $date_today_start = date('Y-m-d');
        $date_today_end = date('Y-m-d');
        $date_today_end = date('Y-m-d', strtotime($date_today_end . '+1 days'));
        
        $greetings = Greeting::whereBetween('display_date', [$date_today_start, $date_today_end])->get();

        $channel_id = 'UCssxoAIGBTKypuwhNKRriZw';
        $api_key = 'AIzaSyDE83HNk_q6TFw7XvgdAQLOGDkyclD2-y0';
        $youtube_live = new EmbedYoutubeLiveStreaming($channel_id, $api_key);

        $embed_code = $youtube_live->isLive() ? $youtube_live->embedCode : null;

        return view('user.home', compact('greetings', 'embed_code'));
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
