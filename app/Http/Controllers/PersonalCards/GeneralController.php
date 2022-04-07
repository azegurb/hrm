<?php

namespace App\Http\Controllers\PersonalCards;

use App\Library\FileOperations\DocxConversion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{
    public function index()
    {
        if(priviligies() == 1){
            if(!is_null(selected())){

                $hasId = 500;

                $userInfo = app('App\Http\Controllers\Auth\UsersController')->getUserById(selected()->userId,'rawJson');

                $userlist = app('App\Http\Controllers\Auth\UsersController')->getUsers('raw');

                $tree = app('App\Http\Controllers\StaffTable\StructuresController')->tree('raw');

                $tree = json_encode($tree, JSON_HEX_APOS );


                return view('pages.personal_cards.index' , compact('userlist','hasId','userInfo','tree'));
            }else{
                $hasId = 200;

                $userlist = app('App\Http\Controllers\Auth\UsersController')->getUsers('raw');

                $tree = app('App\Http\Controllers\StaffTable\StructuresController')->tree('raw');

                $tree = json_encode($tree);


                return view('pages.personal_cards.index', compact('userlist','hasId' , 'tree'));
            }
        }else{
            $hasId = 401;
            return view('pages.personal_cards.index' , compact('hasId'));
        }
//        }catch (\Exception $e){
//            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
//        }
    }
}
