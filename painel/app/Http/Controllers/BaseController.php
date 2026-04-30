<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    
    protected function IsAuthenticated(): bool {
        return Auth::id() > 0;
    }

}