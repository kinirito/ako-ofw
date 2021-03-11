<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FacebookStreaming;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FacebookStreamingController extends Controller
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
     * Get a validator for edit streaming settings request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function editValidator(array $data)
    {
        return Validator::make($data, [
            'embed_code' => ['nullable', 'string'],            
            'is_broadcast' => ['boolean']
        ]);
    }

    /**
     * Show the application facebook live streaming settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$streaming = FacebookStreaming::first();

    	return view('user.facebook', compact('streaming'));
    }

    /**
     * Handle an edit streaming settings request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateFacebookStreaming(Request $request)
    {
        //$this->editValidator($request->all())->validate();

        $streaming = FacebookStreaming::first();
        $streaming->embed_code = $request->embed_code;
        $streaming->is_broadcast = $request->embed_code != null && $request->is_broadcast;
        $streaming->save();
        
        if ($streaming != null)
        {
            if ($request->embed_code == null && $request->is_broadcast)
            {
                return redirect()->back()->with(session()->flash('alert-warning', 'Broadcasting disabled because Embed Code is empty'));
            }
            return redirect()->back()->with(session()->flash('alert-success', 'Facebook Live Settings updated successfully.'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }
}
