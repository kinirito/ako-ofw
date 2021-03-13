<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('revalidate');
    }

    /**
     * Show the application members list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = DB::table('users')->select('users.id', 'users.avatar', 'users.last_name', 'users.first_name', 'users.middle_name', 'users.username', 'users.email', 'users.birthdate', 'users.contact', 'users.facebook', 'users.agency', 'users.occupation', 'users.address', 'countries.country')->join('countries', 'users.country_id' , '=', 'countries.id')->where(['is_admin' => false])->orderBy('id', 'DESC')->paginate(10);

        if ($request->search != null || $request->sorting != null)
        {
            $users = DB::table('users')->select('users.id', 'users.avatar', 'users.last_name', 'users.first_name', 'users.middle_name', 'users.username', 'users.email', 'users.birthdate', 'users.contact', 'users.facebook', 'users.agency', 'users.occupation', 'users.address', 'countries.country')->join('countries', 'users.country_id' , '=', 'countries.id')->where(['is_admin' => false])->where(function ($query) use ($request) {
                $query->where(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere(DB::raw("CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`)"), 'LIKE', '%' . $request->search . '%')->orWhere('username', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('agency', 'LIKE', '%' . $request->search . '%')->orWhere('occupation', 'LIKE', '%' . $request->search . '%')->orWhere('address', 'LIKE', '%' . $request->search . '%');
            })->orderBy('id', $request->sorting)->paginate(10);
        }

        $users->appends(request()->input())->links();

        return view('user.members', compact('users', 'request'));
    }

    /**
     * Handle a asking user's condition request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function kumustahin(Request $request)
    {
        $user = User::find($request->user_id);
        $user->is_status_answered = false;
        $user->save();

        if ($user != null)
        {
            return redirect()->back()->with(session()->flash('alert-success', $user->first_name . ' ' . $user->last_name . ' notified successfully.'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Handle a asking all users conditions request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function kumustahinAll(Request $request)
    {
        User::query()->update(['is_status_answered' => 0]);

        return redirect()->back()->with(session()->flash('alert-success', 'All users notified successfully.'));
    }
}
