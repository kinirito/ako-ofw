<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class RegisterIDController extends Controller
{
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
        $this->middleware('auth');
        $this->middleware('revalidate');
        $this->middleware('first.login');
    }

    /**
     * Show registration ID to the user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user != null) {
            $save_path = public_path() . '/images/ID/card_' . $user->id . '.jpg';
            $id_card_front = Image::make(public_path() . '/images/assets/id_card_front.png');
            $avatar = Image::make(public_path() . '/images/avatars/' . $user->avatar)->fit(284, 332);
            $id_card_front->insert($avatar, 'top-left', 80, 169);
            
            $name = explode('\n', wordwrap(strtoupper($user->first_name . ' ' . $user->last_name), 22, '\n'));
            $y_position = 420 - (count($name, true) * 37);
            foreach ($name as $name_line) {
                $id_card_front->text($name_line, 595, $y_position, function($font) {
                    $font->file('fonts/calibri.ttf');
                    $font->size(35);
                    $font->color('#000000');
                    $font->align('center');
                    $font->valign('bottom');
                    $font->angle(0);
                });

                $y_position += 37;
            }
            
            $id_card_front->text(date('Y', strtotime($user->created_at)) . sprintf('%010d', $user->id), 595, 410, function($font) {
                $font->file('fonts/calibri.ttf');
                $font->size(35);
                $font->color('#000000');
                $font->align('center');
                $font->valign('center');
                $font->angle(0);
            });
            if (File::exists($save_path))
            {
                File::delete($save_path);
            }
            $id_card_front->save($save_path);

            return view('auth.register-id')->with(session()->flash('alert-success', 'Your account has been created. Please check email for verification link'));
        }

        return redirect()->route('home');
    }
}
