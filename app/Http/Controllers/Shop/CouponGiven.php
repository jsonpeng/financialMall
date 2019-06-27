<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;

class CouponGiven extends Controller
{
    public function index()
    {
    	return view('shop.coupons.given');
    }
}
