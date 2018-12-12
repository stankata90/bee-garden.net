<?php
    function my_is_specsym( string $str ) {
        $arrSymbols = array(
            '<',
            '>',
            '~',
            '"',
            '\'',
            '?',
            '*',
            ',',
            '%',
            ';',
            '$'
        );

        for ( $i=0; $i<my_strlen($str); $i++ ) {
           if( in_array( $str[$i], $arrSymbols ) ) {
                return true;
           }
        }

        return false;
    }