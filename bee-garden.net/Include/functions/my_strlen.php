<?php
    function my_strlen( string $str, string $encoding='UTF-8' ) {

    return mb_strlen( $str, $encoding );
    }
