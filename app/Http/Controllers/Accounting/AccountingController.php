<?php

namespace App\Http\Controllers\Accounting;

use App\Library\Ws\Filter;
use App\Payment;
use App\UserPayments;
use App\UserPositions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountingController extends Controller
{
    /**
     * List cotents of your page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.accounting.index');
    }
}
