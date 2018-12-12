<?php
namespace Interfaces;

use Engines\frontEngine;
use Engines\viewEngine;

class pageController
{
    /** @var frontEngine */
    private $frontEngine;

    /** @var viewEngine */
    private $viewEngine;


    function __construct(frontEngine $frontEngine )
    {
        $this->frontEngine = $frontEngine;
        $this->viewEngine = new viewEngine( $frontEngine );

    }

    /**
     * @return frontEngine
     */
    public function getFrontEngine(): frontEngine
    {
        return $this->frontEngine;
    }


    /**
     * @return viewEngine
     */
    public function getViewEngine(): viewEngine
    {
        return $this->viewEngine;
    }



}