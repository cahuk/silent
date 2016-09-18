<?php

namespace silent\core\base;

/**
 * Class BaseRequest
 * @package silent\core\base
 */
abstract class BaseRequest
{
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    abstract public function getParam($key, $default=null);

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    abstract public function getQuery($key, $default=null);

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    abstract public function getPost($key, $default=null);

    /**
     * @return mixed
     */
    abstract public function getUrl();

    /**
     *
     */
    abstract public function getRequestUri();

    /**
     * @return string path info /fdd/fff?fsdf=fds without get param after ?fsdf=fds...
     */
    abstract public function getPathInfo();



}