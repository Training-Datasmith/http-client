<?php

declare (strict_types=1);
namespace Psr\Http\Client;

use Psr\Http\Message\Request_Interface;
use Psr\Http\Message\Response_Interface;
interface Client_Interface
{
    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     *
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface If an error happens while processing the request.
     */
    public function send_request(Request_Interface $request): Response_Interface;
}