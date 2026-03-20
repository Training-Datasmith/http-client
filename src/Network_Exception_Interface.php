<?php

declare (strict_types=1);
namespace Psr\Http\Client;

use Psr\Http\Message\Request_Interface;
/**
 * Thrown when the request cannot be transmitted due to a network-layer failure.
 *
 * This exception is raised when no response is received from the server because
 * the TCP/IP layer itself failed. Common causes: DNS resolution failure, connection
 * refused (server not listening), TLS handshake error, or a dropped connection
 * mid-transfer. Because no response exists, there is no Response_Interface to return.
 *
 * @since 1.0
 * @see Request_Exception_Interface For failures caused by a malformed request.
 */
interface Network_Exception_Interface extends Client_Exception_Interface
{
    /**
     * Returns the request that triggered this network failure.
     *
     * The returned request object MAY differ from the one originally passed to
     * Client_Interface::send_request() if the client modified it (e.g., added
     * default headers or resolved a relative URI) before attempting transmission.
     *
     * @return Request_Interface The request that was being sent when the
     *   network error occurred. Useful for logging and retry logic.
     *
     * @since 1.0
     */
    public function get_request(): Request_Interface;
}