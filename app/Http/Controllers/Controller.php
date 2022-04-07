<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $page;
    protected $limit;
    protected $offset;
    protected $search;
    protected $load;

    public function __construct()
    {
        $this->page   = is_numeric(Input::get('page')) && Input::get('page') > 0 ? Input::get('page') : 1;
        $this->limit  = is_numeric(Input::get('limit')) && Input::get('limit') > 0 ? Input::get('limit') : 10;
        $this->search = !empty(Input::get('search')) || Input::get('search') != 'undefined' ? Input::get('search') : '';
        $this->offset = ($this->page-1) * $this->limit;
        $this->load   = !empty(Input::get('load')) ? Input::get('load') : false;
    }

}
