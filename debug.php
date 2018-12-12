<?php
    $intA = readline();
    $intB = readline();

    $result = 0;
    while( $intA == 0 ) {
        if( $intA % 2 == $intB ) {
            $result++;
        }

        $intA /= 2;
    }

    echo $result;