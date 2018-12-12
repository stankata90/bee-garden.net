<?php
namespace Interfaces;

use Engines\frontEngine;

class rootModels
{
    /** @var  frontEngine $frontEngine*/
    private $frontEngine;

    function __construct(frontEngine $frontEngine )
    {
        $this->frontEngine = $frontEngine;
    }

    /** @return frontEngine */
    public function getFrontEngine(): frontEngine
    {
        return $this->frontEngine;
    }



}