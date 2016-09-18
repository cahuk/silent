<?php

namespace silent\core\base;

use silent\core\base\BaseRequest;

/**
 * Class BaseRoute
 * @package silent\core\base
 */
abstract class BaseRoute
{
    /** @var \silent\core\base\BaseRequest */
    protected $route;


    /**
     * BaseRoute constructor.
     * @param \silent\core\base\BaseRequest $route
     */
    public function __construct(BaseRequest $route)
    {
        $this->route = $route;
    }

}