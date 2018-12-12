<?php
    function my_tobytes($value ) {
        if ( is_numeric( $value ) ) {
            return $value;
        } else {
            $value_length = strlen($value);
            $qty = substr( $value, 0, $value_length - 1 );
            $unit = strtolower( substr( $value, $value_length - 1 ) );
            switch ( $unit ) {
                case 'k':
                    $qty *= 1024;
                    break;
                case 'm':
                    $qty *= 1048576;
                    break;
                case 'g':
                    $qty *= 1073741824;
                    break;
            }
            return $qty;
        }
    }


