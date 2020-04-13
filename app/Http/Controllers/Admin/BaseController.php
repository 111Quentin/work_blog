<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            return redirect('/admin/login');
        }
    }
}
