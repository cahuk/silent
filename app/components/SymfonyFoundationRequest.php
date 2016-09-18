<?php

namespace silent\app\components;

use silent\core\base\BaseRequest;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class SymfonyFoundationRequest
 * @package silent\app\components
 */
class SymfonyFoundationRequest extends BaseRequest
{
    /** @var \Symfony\Component\HttpFoundation\Request; */
    protected $request;


    /**
     * SymfonyFoundationRequest constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getParam($key, $default = null)
    {
        return $this->request->query->get($key) ?: $this->request->get($key) ?: $default;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getQuery($key, $default = null)
    {
        return $this->request->query->get($key) ?: $default;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getPost($key, $default = null)
    {
        return $this->request->get($key) ?: $default;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->request->getUri();
    }

    /**
     *
     */
    public function getQueryStr()
    {
        return $this->request->getQueryString();
    }

    /**
     *
     */
    public function getRequestUri()
    {
        return $this->request->getRequestUri();
    }

    /**
     *
     */
    public function getPathInfo()
    {
       return $this->request->getPathInfo();
    }

}