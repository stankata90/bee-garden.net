<?php
    $intA = readline();
    $intB = readline();

    $result = 0;
    $strNember = '';

    while( $intA != 0 ) {

        if( $intA % 2 == $intB ) {
            $result++;
        }


        $strNember .= $intA % 2;
        $intA =  floor( $intA / 2 );
    }

    $strNember = strrev ( $strNember );

    echo $strNember . PHP_EOL;
    
    echo "by stankata";

    echo 'komplromisa';