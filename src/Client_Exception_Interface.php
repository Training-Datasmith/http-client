<?php

declare (strict_types=1);
namespace Psr\Http\Client;

/**
 * Marker interface for all exceptions thrown by a PSR-18 HTTP client.
 *
 * Every exception thrown from Client_Interface::send_request() MUST implement
 * this interface. Catching it allows consuming code to handle all HTTP client
 * errors in a single block, regardless of whether they were request-level
 * (malformed request) or network-level (connection failure).
 *
 * Note: HTTP error status codes (4xx, 5xx) are NOT exceptions; they are
 * returned as valid Response_Interface objects.
 *
 * @since 1.0
 * @see https://www.php-fig.org/psr/psr-18/
 */
interface Client_Exception_Interface extends \Throwable
{
}