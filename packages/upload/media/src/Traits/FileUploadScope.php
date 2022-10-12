<?php

namespace Upload\Media\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FileUploadScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        return $model;
    }

    protected function file_upload()
    {
        return "hello from file upload";
    }
}
