<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Banner;
use App\Models\Tour;
use App\Models\Package;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $banner = Banner::where('page', 'home')->where('status', 'active')->first();
        $featuredTours = Tour::where('status', 'active')->where('is_featured', 1)->latest()->get();
        $featuredPackages = Package::where('status', 'active')->where('is_featured', 1)->latest()->get();
        return view('frontend.home', compact('banner', 'featuredTours', 'featuredPackages'));
    }
    public function privacy_policy()
    {
        return view('frontend.privacy-policy');
    }
    public function testOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $data = compact('order');
        // order-created-user
        return view('emails.order-created-admin')->with($data);
    }
    public function terms_and_conditions()
    {
        return view('frontend.terms-conditions');
    }
    public function company_profile()
    {
        return view('frontend.company-profile');
    }
    public function about_us()
    {
        $banner = Banner::where('page', 'about-us')->where('status', 'active')->first();
        return view('frontend.about-us', compact('banner'));
    }
    public function contact_us()
    {
        $banner = Banner::where('page', 'contact-us')->where('status', 'active')->first();
        return view('frontend.contact-us', compact('banner'));
    }

    public function subscribeNewsletter(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:newsletters,email',
            ]);

            Newsletter::create([
                'email' => $request->email,
            ]);

            return back()->with('notify_success', 'Newsletter subscribed successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->join(', ');
            return back()->with('notify_error', $errors);
        }
    }

    public function submitContact(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'message' => 'required|string',
                'g-recaptcha-response' => 'required',
            ]);

            Inquiry::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);

            return back()->with('notify_success', 'Thank you for contacting us! We will get back to you soon.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->join(', ');
            return back()->with('notify_error', $errors);
        }
    }
}
