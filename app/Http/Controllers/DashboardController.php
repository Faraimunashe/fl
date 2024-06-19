<?php

namespace App\Http\Controllers;


use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('admin'))
        {
            return redirect()->route('admin-dashboard');
        }elseif(Auth::user()->hasRole('officer'))
        {
            return redirect()->route('officer-dashboard');
        }
        else{
            return redirect()->route('user-dashboard');
        }
    }


}
