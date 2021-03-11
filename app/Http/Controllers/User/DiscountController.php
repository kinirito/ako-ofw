<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class DiscountController extends Controller
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
     * Get a validator for add discount request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function addValidator(array $data)
    {
        return Validator::make($data, [
            'add_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],            
            'add_brand' => ['required', 'string', 'max:255'],
            'add_description' => ['required', 'string', 'max:255']
        ]);
    }

    /**
     * Get a validator for edit discount request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function editValidator(array $data)
    {
        return Validator::make($data, [
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],            
            'brand' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ]);
    }

    /**
     * Show the application discounts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $discounts = Discount::paginate(10);

        if ($request->search != null)
        {
            $discounts = Discount::where('brand', 'LIKE', '%' . $request->search . '%')->orWhere('description', 'LIKE', '%' . $request->search . '%')->paginate(10);
        }

        $discounts->appends(request()->input())->links();

        return view('user.discounts', compact('discounts', 'request'));
    }

    /**
     * Handle an add discount request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function addDiscount(Request $request)
    {
        $this->addValidator($request->all())->validate();

        $discount = new Discount();
        $discount->brand = $request->add_brand;
        $discount->description = $request->add_description;
        $discount->save();

        if ($discount != null)
        {
            if ($request->hasFile('add_logo')) {
                $image_name = 'promo_' . $discount->id . '.jpg';
                $save_path = public_path() . '/images/discounts/' . $image_name;
                if (File::exists($save_path))
                {
                    File::delete($save_path);
                }
                $image = Image::make($request->file('add_logo'))->fit(200);
                $image->save($save_path);
                $discount->logo = $image_name;
                $discount->save();
            }

            return redirect()->back();
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Handle an edit discount request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function editDiscount(Request $request)
    {
        $this->editValidator($request->all())->validate();

        $discount = Discount::find($request->discount_id);
        $discount->brand = $request->brand;
        $discount->description = $request->description;
        if ($request->hasFile('logo')) {
            if ($discount->logo != 'default_discount.jpg')
            {
                File::delete(public_path() . '/images/discounts/' . $discount->logo);
            }
            $image_name = 'promo_' . $discount->id . '.jpg';
            $save_path = public_path() . '/images/discounts/' . $image_name;
            if (File::exists($save_path))
            {
                File::delete($save_path);
            }
            $image = Image::make($request->file('logo'))->fit(200);
            $image->save($save_path);
            $discount->logo = $image_name;
        }
        $discount->save();

        if ($discount != null)
        {
            return redirect()->route('discounts')->with(session()->flash('alert-success', $discount->brand . ' changed successfully.'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }

    /**
     * Handle an delete discount request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function deleteDiscount(Request $request)
    {
        $discount = Discount::find($request->discount_id);

        if ($discount != null)
        {
            if ($discount->logo != 'default_discount.jpg')
            {
                File::delete(public_path() . '/images/discounts/' . $discount->logo);
            }

            $discount->delete();
        }
        
        
        return redirect()->back()->with(session()->flash('alert-success', 'Discount item deleted successfully.'));
    }
}
