<?php

namespace App\Classes\Helpers;

class QueryBuilder
{
    protected string $query;
    protected array $joins = [];
    protected  array $where = [];

    public function joins($type='inner', $params =[]) {

        $this->joins[$type][] = [

        ];
    }
}
