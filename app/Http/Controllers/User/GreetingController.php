<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Greeting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class GreetingController extends Controller
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
     * Get a validator for add greeting request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function addValidator(array $data)
    {
        return Validator::make($data, [
            'add_greeting' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],            
            'add_display_date' => ['required', 'date']
        ]);
    }

    /**
     * Get a validator for edit greeting request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function editValidator(array $data)
    {
        return Validator::make($data, [
            'greeting' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],            
            'display_date' => ['required', 'date']
        ]);
    }

    /**
     * Show the application welcome greetings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $date_from = $request->date_from != null ? $request->date_from : date('Y-m-d');
        $date_to = $request->date_to != null ? $request->date_to : date('Y-m-d');
        $date_to = date('Y-m-d', strtotime($date_to . '+1 days'));

        $greetings = Greeting::whereBetween('display_date', [$date_from, $date_to])->paginate(10);

        $greetings->appends(request()->input())->links();

        return view('user.greetings', compact('greetings', 'request'));
    }

    /**
     * Handle an add greeting request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function addGreeting(Request $request)
    {
        $this->addValidator($request->all())->validate();

        $greeting = new Greeting();
        $greeting->display_date = $request->add_display_date;
        $greeting->save();

        if ($greeting != null)
        {
            if ($request->hasFile('add_greeting')) {
                $image_name = 'greet_' . $greeting->id . '.jpg';
                $save_path = public_path() . '/images/greetings/' . $image_name;
                if (File::exists($save_path))
                {
                    File::delete($save_path);
                }
                $image = Image::make($request->file('add_greeting'));
                $image->save($save_path);
                $greeting->greeting = $image_name;
                $greeting->save();
            }

            return redirect()->back();
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Handle an edit greeting request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function editGreeting(Request $request)
    {
        $this->editValidator($request->all())->validate();

        $greeting = Greeting::find($request->greeting_id);
        $greeting->display_date = $request->display_date;
        if ($request->hasFile('greeting')) {
            if ($greeting->greeting != 'default_greeting.png')
            {
                File::delete(public_path() . '/images/greetings/' . $greeting->greeting);
            }
            $image_name = 'greet_' . $greeting->id . '.jpg';
            $save_path = public_path() . '/images/greetings/' . $image_name;
            if (File::exists($save_path))
            {
                File::delete($save_path);
            }
            $image = Image::make($request->file('greeting'));
            $image->save($save_path);
            $greeting->greeting = $image_name;
        }
        $greeting->save();
        
        if ($greeting != null)
        {
            return redirect()->back();
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Handle an delete greeting request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function deleteGreeting(Request $request)
    {
        $greeting = Greeting::find($request->greeting_id);

        if ($greeting != null)
        {
            if ($greeting->greeting != 'default_greeting.png')
            {
                File::delete(public_path() . '/images/greetings/' . $greeting->greeting);
            }

            $greeting->delete();
        }
        
        return redirect()->back()->with(session()->flash('alert-success', 'Greeting deleted successfully.'));
    }
}
