<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Country;
use App\Http\Controllers\MailController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('revalidate');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'username' => ['unique:users,username', 'required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birthdate' => ['required', 'date'],
            'contact' => ['required', 'string', 'max:255'],
            'agency' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'numeric', 'max:255']
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = new User();
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->birthdate = $request->birthdate;
        $user->contact = $request->contact;
        $user->agency = $request->agency;
        $user->occupation = $request->occupation;
        $user->address = $request->address;
        $user->country_id = $request->country_id;
        $user->verification_code = sha1(time());
        $user->save();

        if ($user != null) {
            if ($request->hasFile('avatar')) {
                $image_name = 'user_' . $user->id . '.jpg';
                $save_path = '/images/avatars/' . $image_name;
                if (File::exists($save_path))
                {
                    File::delete($save_path);
                }
                $image = Image::make($request->file('avatar'))->fit(400);
                $image->save($save_path);
                $user->avatar = $image_name;
                $user->save();
            }
            MailController::sendSignupEmail($user->email, $user->verification_code);
            Auth::login($user);

            return redirect()->route('register.id')->with(session()->flash('alert-success', 'Your account has been created. Please check email for verification link'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $countries = Country::all();

        return view('auth.register', compact('countries'));
    }

    /**
     * Verify user from email received.
     *
     * @return \Illuminate\View\View
     */
    public function verifyUser(Request $request)
    {
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $user = User::where(['verification_code' => $verification_code])->first();
        if ($user != null)
        {
            $user->is_verified = 1;
            $user->save();
            return redirect()->route('login')->with(session()->flash('alert-success', 'Your account has been created. Please check email for verification link.'));
        }

        return redirect()->route('login')->with(session()->flash('alert-danger', 'Invalid verification code'));
    }
}
