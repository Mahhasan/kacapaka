<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function showCart()
    {
        return view('frontend.cart');
    }
    public function showChackout()
    {
        return view('frontend.checkout');
    }
    public function NotFound()
    {
        return view('frontend.404');
    }
    public function showContact()
    {
        return view('frontend.contact');
    }
    public function showShop()
    {
        return view('frontend.shop');
    }
    public function showProductDetails()
    {
        return view('frontend.product-details');
    }
    public function showTestimonial()
    {
        return view('frontend.testimonial');
    }
}
