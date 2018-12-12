<?php
    function my_strabb( string $string, int $length, string $abb='...' ) {
        if( my_strlen( $string ) > $length ) {
            return my_substr( $string, 0, $length ) . $abb;
        } else {
            return $string;
        }
    }