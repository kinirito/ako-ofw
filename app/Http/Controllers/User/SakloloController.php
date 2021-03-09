<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Reason;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SakloloController extends Controller
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
     * Get a validator for a saklolo request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'reason_id' => ['required', 'numeric', 'max:255'],
            'scenario' => ['nullable', 'string', 'max:255']
        ]);
    }

    /**
     * Show the application saklolo.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $reasons = Reason::all();

        return view('user.saklolo', compact('reasons'));
    }

    /**
     * Handle a user not in good condition request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function hindiMabutiStatus(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = Auth::user();
        $user->is_status_answered = true;
        $user->save();

        if ($user != null)
        {
            $status = new Status();
            $status->user_id = $user->id;
            $status->is_okay = false;
            $status->reason_id = $request->reason_id;
            $status->scenario = $request->scenario;
            $status->save();
            return redirect()->back()->with(session()->flash('alert-success', 'Report send successfully'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }
}
