<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\User;

class DistributionController extends AppBaseController
{
    public function stats()
    {
    	return view('shop.distributions.stats');
    }

    public function lists(Request $request)
    {
    	$users = User::where('is_distribute', 1)->paginate($this->defaultPage());
    	return view('shop.distributions.lists', compact('users'));
    }

    public function settings(Request $request)
    {
    	return view('shop.distributions.settings');
    }
}
