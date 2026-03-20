<?php

declare (strict_types=1);
namespace Psr\Http\Client;

use Psr\Http\Message\Request_Interface;
/**
 * Thrown when the request cannot be completed because of network issues.
 *
 * There is no response object as this exception is thrown when no response has been received.
 *
 * Example: the target host name can not be resolved or the connection failed.
 */
interface Network_Exception_Interface extends Client_Exception_Interface
{
    /**
     * Returns the request.
     *
     * The request object MAY be a different object from the one passed to ClientInterface::sendRequest()
     */
    public function get_request(): Request_Interface;
}