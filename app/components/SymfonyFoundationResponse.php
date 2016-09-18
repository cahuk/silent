<?php

namespace silent\app\components;

use silent\core\base\BaseResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SymfonyFoundationResponse
 * @package silent\app\components
 */
class SymfonyFoundationResponse extends BaseResponse
{
    /** @var  \Symfony\Component\HttpFoundation\Response */
    protected $response;

    /**
     * SymfonyFoundationResponse constructor.
     */
    public function __construct()
    {
        $this->response = new Response();
    }

}