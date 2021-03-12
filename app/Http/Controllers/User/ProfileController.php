<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
     * Get a validator for a profile edit request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function profileValidator(array $data)
    {
        return Validator::make($data, [
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'username' => ['unique:users,username,' . Auth::user()->id, 'required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'contact' => ['required', 'string', 'max:255'],
            'agency' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'numeric', 'max:255']
        ]);
    }

    /**
     * Get a validator for a change password request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'current_password' => ['required', 'string', 'min:8', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password))
                {
                    $fail('Incorrect current password');
                }
            }],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password']
        ]);
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countries = Country::all();

        return view('user.profile', compact('countries'));
    }

    /**
     * Handle a update user request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $this->profileValidator($request->all())->validate();

        $user = Auth::user();
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->username = $request->username;
        $user->birthdate = $request->birthdate;
        $user->contact = $request->contact;
        $user->agency = $request->agency;
        $user->occupation = $request->occupation;
        $user->address = $request->address;
        $user->country_id = $request->country_id;
        if ($request->hasFile('avatar')) {
            if ($user->avatar != 'default_avatar.jpg')
            {
                File::delete(public_path() . '/images/avatars/' . $user->avatar);
            }
            $image_name = 'user_' . $user->id . '.jpg';
            $save_path = public_path() . '/images/avatars/' . $image_name;
            if (File::exists($save_path))
            {
                File::delete($save_path);
            }
            $image = Image::make($request->file('avatar'))->fit(400);
            //$image->save($save_path);
            //$user->avatar = $image_name;
        }
        $user->save();

        if ($user != null) {
            return redirect()->route('profile')->with(session()->flash('alert-success', 'Changes to Profile saved successfully.'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Handle a update password request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $this->passwordValidator($request->all())->validate();

        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            if ($user != null) {
                return redirect()->route('profile')->with(session()->flash('alert-success', 'Password changed successfully.'));
            }
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }
}
