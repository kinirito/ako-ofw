<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupEmail;

class MailController extends Controller
{
    public static function sendSignupEmail($email, $verification_code)
    {
    	$data = [
    		'verification_code' => $verification_code
    	];
    	
    	Mail::to($email)->send(new SignupEmail($data));
    }

    public static function sendResetPasswordEmail($email, $reset_password_token)
    {
    	$data = [
    		'reset_password_token' => $reset_password_token
    	];
    	
    	Mail::to($email)->send(new SignupEmail($data));
    }
}
