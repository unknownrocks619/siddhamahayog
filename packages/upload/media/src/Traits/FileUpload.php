<?php

namespace Upload\Media\Traits;

use Exception;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Upload\Media\Models\Media;


trait FileUpload
{

    private $_upload_path = "website";
    private $_access = "DB";


    public static function model()
    {
        return static::class;
    }

    public function set_upload_path($path)
    {
        $this->_upload_path = $path;
    }

    /**
     * Set How do you want to return 
     * media that has been upload
     * 
     * DB : Upload the file in db and return corresponding ID
     * FILE: Upload The file and return all params
     * @param string $access
     * @return null;
     */
    public function set_access($access)
    {
        $this->_access = $access;
    }

    public function upload($filename = "file")
    {

        if (!request()->hasFile($filename)) {
            throw new Exception($filename . " not found or doesn't exists.");
        }

        $file_detail = [
            "original_filename" => request()->file($filename)->getClientOriginalName(),
            // "file_type" => request()->file($filename)->getMimeType(),
            "path" => Storage::putFile($this->_upload_path, request()->file($filename)->path()),
        ];
        if ($this->_access == "DB") {
            $upload_model = new Media;
            $upload_model->media = $file_detail;
            $upload_model->type = $file_detail["file_type"];
            $upload_model->file_size = request()->file($filename)->getSize();

            try {
                $upload_model->save();
            } catch (\Throwable $th) {
                throw $th;
            }

            return $upload_model;
        }
        $file_detail[] = [
            "file_type" => request()->file($filename)->getMimeType(),
            "size" => request()->file($filename)->getSize()
        ];
        return $file_detail;
    }

    public function upload_by_resource($file_resource)
    {

        $file_detail = [
            "original_filename" => $file_resource->getClientOriginalName(),
            // "file_type" => $file_resource->getMimeType(),
            "path" => Storage::putFile($this->_upload_path, $file_resource->path()),
        ];
        if ($this->_access == "DB") {
            $upload_model = new Media;
            $upload_model->media = $file_detail;
            $upload_model->type = $file_detail["file_type"];
            $upload_model->file_size = $file_resource->getSize();

            try {
                $upload_model->save();
            } catch (\Throwable $th) {
                throw $th;
            }

            return $upload_model;
        }
        $file_detail["meta"] = [
            "file_type" => $file_resource->getMimeType(),
            "size" => $file_resource->getSize()
        ];
        return $file_detail;
    }
}
