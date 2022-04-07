<?php

namespace App\Composer;

use App\CRUD\CRUD;
use App\Http\Controllers\Controller;
use App\Library\Service\Service;
use Illuminate\View\View;

class MenuComposer
{
    public $menus;

    public function __construct()
    {
        try{
            $data = Service::request([
                'method'  => 'GET',
                'url'     => Service::url('central','Menu/catalogs' , false),
                'params'  => [
                ],
                'options' => [
                    'headers' => [
                        'TableName' => ''
                    ]
                ]
            ]);
            $this->data = $data->data->menu;
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }

    public function compose(View $view)
    {
        try{
            $view->with('menus', $this->data);
        }catch (\Exception $e){
            return exceptionH(\Request::ajax(),$e->getCode(),$e->getMessage());
        }
    }
}
