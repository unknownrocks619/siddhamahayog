<?php

namespace App\Classes\Helpers;

class Str
{
    /**
     * @param $model
     * @return string
     */
    public static function uuid($model=null): string {
        $uuid = \Illuminate\Support\Str::uuid();
        $toArray = explode('-',$uuid);
        $finalString = $toArray[count($toArray)-1];

        if ($model && $model->getKey() ) {
            $finalString = $finalString.'-'.$model->getKey();
        }

        return $finalString;
    }
}
