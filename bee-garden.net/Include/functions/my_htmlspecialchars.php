<?php
    function my_htmlspecialchars($string ) {
        $funcName = __FUNCTION__;

        if( is_array( $string ) ) {
            $arr = [];
            for ( $i=0; $i<count($string); $i++ ) {
                $arr[$i] = $funcName( $string[$i] );
            }

            return $arr;
        }

        return htmlspecialchars( $string );
    }
