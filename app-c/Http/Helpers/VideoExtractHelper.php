<?php 
if ( ! function_exists("vimeo_video_extract") ) {
    
    /**
     * Extract video id from given full url
     * @param URL|String $full_link
     * @return Int
     */
    function vimeo_video_id_extract($full_link) {

        return filter_var($full_link,FILTER_SANITIZE_NUMBER_INT);

    }
}
?>