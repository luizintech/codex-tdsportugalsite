<?php

namespace App\Http\Controllers;

use App\ViewModels\DashboardViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends BaseController
{
    public function index()
    {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new DashboardViewModel(); 
        return view('index', compact('viewModel'));
    }
}
