<?php
if (!function_exists("default_image")) {

    function default_image($broken = false)
    {

        if ($broken) {
            // return broken image 
        }

        return;
    }
}

if (!function_exists("image_by_file_type")) {

    /**
     * Display Image According to 
     * provided file name or file type.
     * @param String $file
     * @return String Img
     * 
     */
    function image_by_file_type($file)
    {
        /**
         * check passed param for two option
         * file type and actual filename
         */

        $file_types = [
            "image/jpeg" => default_image(),
            "image/png" => default_image(),
            'application/pdf' => "",
            'application/x-' => ""
        ];

        if (array_key_exists($file, $file_types)) {
            return $file_types[$file];
        }

        return default_image();
    }
}


if (!function_exists("banner_image")) {

    function bannner_image($image, $access_field = null)
    {
        $json_image = json_decode($image);

        if ($json_image && isset($json_image->$access_field)) {
            return asset(($json_image->$access_field->path));
        }
        return default_image();
    }
}
