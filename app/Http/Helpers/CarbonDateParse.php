<?php 
if (! function_exists("carbon_date_parse") ) {

    /**
     * parse given string date to date time object
     * @param String $date
     * @return Object
     */
    function carbon_date_parse($date) {
        return \Carbon\Carbon::parse($date);
    }
}


if (! function_exists("carbon_date_format") ) {

    /**
     * return string date to provided format.
     * 
     * @param String $date standard date 
     * @param String $format format to return date
     * @return String
     */
    function carbon_date_format($date,$format="Y-m-d") {
        $parse_record = carbon_date_parse($date);

        return $parse_record->format($format);
    }
}

?>