<?php

namespace App\Http\Controllers\Salary;

use App\Library\Service\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function index(){

                return view('pages.salary.index');

    }
}
