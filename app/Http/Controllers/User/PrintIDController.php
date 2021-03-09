<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class PrintIDController extends Controller
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
        $save_path = public_path() . '/images/ID/card_' . Auth::user()->id . '.jpg';


        $id_card_front = Image::make(public_path() . '/images/assets/id_card_front.png');
        
        $avatar = Image::make(public_path() . '/images/avatars/' . Auth::user()->avatar)->fit(284, 332)->circle(50, 285, 332);
        
        $id_card_front->insert($avatar, 'top-left', 80, 169);
        
        if (File::exists($save_path))
        {
            File::delete($save_path);
        }
        $id_card_front->save($save_path);

        return view('user.print');
    }
}
