<?php

namespace App\Library;

use Illuminate\Support\Facades\Input;

class Pagination
{
    protected $filters  = [];
    protected $entity   = [];
    protected $page     = [];

    public function filter($params = null)
    {

        if(!is_null($params) && is_array($params) && count($params)>0)
        {
            if(isset($params['filters']))
            {
                $this->filters = collect($params['filters'])->all();

                foreach ($this->filters as $key => $value)
                {
                    if(!is_null(Input::get($value)))
                    {
                        $this->entity[$key] = is_numeric(Input::get($value)) ? intval(Input::get($value)):Input::get($value);
                    }
                }
            }
        }

        return $this->entity;
    }

    public function paginate($page, $count, $orderBy = null)
    {
        $page = (is_numeric($page) and $page > 0) ? $page : 1;

        $this->page['start'] = ($page-1)*$count;
        $this->page['count'] = $count;

        if(!is_null($orderBy))
        {
            $this->page['order'] = [
                'column'    => $orderBy['field'],
                'sort'      => $orderBy['type']
            ];
        }

        return $this->page;
    }
}