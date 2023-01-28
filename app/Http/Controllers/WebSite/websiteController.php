<?php

namespace App\Http\Controllers\WebSite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class websiteController extends Controller
{

    public function index()
    {
        return view('student.index');
    }

    public function showCompany()
    {
        return view('student.company');
    }
}
