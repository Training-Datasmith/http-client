<?php

declare (strict_types=1);
namespace Psr\Http\Client;

use Psr\Http\Message\Request_Interface;
use Psr\Http\Message\Response_Interface;

/**
 * Defines a synchronous HTTP client that sends PSR-7 requests.
 *
 * The client MUST NOT throw an exception for HTTP error responses (4xx, 5xx).
 * Those are valid responses and MUST be returned as Response_Interface objects.
 * Exceptions are reserved for failures at the transport layer (network errors,
 * invalid request structure) before a response is received.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-18/
 */
interface Client_Interface
{
    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * The client MUST send the request exactly as given, including method,
     * URI, headers, and body. HTTP-level errors (404, 500, etc.) are NOT
     * exceptions — they are returned as response objects with the appropriate
     * status code. Only transport-layer failures raise exceptions.
     *
     * @param Request_Interface $request The outgoing HTTP request to send.
     *   The request object MUST be fully formed (method, URI, and any required
     *   headers such as Content-Type and Content-Length for requests with a body).
     *
     * @throws Request_Exception_Interface If the request is malformed and
     *   cannot be sent (e.g., missing HTTP method, unreadable body stream).
     * @throws Network_Exception_Interface If the request could not be
     *   transmitted due to a network failure (e.g., DNS resolution failure,
     *   connection refused, or connection dropped mid-transfer).
     *
     * @return Response_Interface The HTTP response received from the server.
     *   HTTP 4xx and 5xx status codes are returned as responses, not thrown.
     *
     * @since 1.0
     */
    public function send_request(Request_Interface $request): Response_Interface;
}