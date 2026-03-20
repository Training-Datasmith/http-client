<?php

declare (strict_types=1);
namespace Psr\Http\Client;

use Psr\Http\Message\Request_Interface;
/**
 * Thrown when a request is invalid and cannot be sent.
 *
 * This exception is raised before any network communication when the request
 * object itself is malformed or unusable. Examples:
 *   - Missing or invalid HTTP method.
 *   - Body stream that is not readable or not seekable when required.
 *   - URI that cannot be resolved to a valid target.
 *
 * Unlike Network_Exception_Interface, this exception indicates the problem
 * lies with the request structure, not the network.
 *
 * @since 1.0
 * @see Network_Exception_Interface For failures at the transport layer.
 */
interface Request_Exception_Interface extends Client_Exception_Interface
{
    /**
     * Returns the malformed or problematic request that caused this exception.
     *
     * The returned request object MAY differ from the one originally passed to
     * Client_Interface::send_request() if the client modified it before the
     * validation failure was detected.
     *
     * @return Request_Interface The request that failed validation. Inspect
     *   method, URI, and headers to diagnose the problem.
     *
     * @since 1.0
     */
    public function get_request(): Request_Interface;
}