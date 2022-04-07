<?php

namespace App\Http\Controllers\PersonalCards;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index()
    {
        return view('components.chat');
    }
}
