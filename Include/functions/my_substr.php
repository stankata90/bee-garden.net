<?php
    function my_substr( string $str, int $start, int $end, string $encoding='UTF-8'){

        return mb_substr( $str, $start, $end, $encoding);
    }
