<?php

declare(strict_types=1);

/**
 * Example: Using PSR-18 Client_Interface with PSR-7 messages.
 *
 * Type-hint Client_Interface so your library works with any PSR-18 client
 * (Guzzle, Symfony HttpClient, Buzz, etc.) without modification.
 */

use Psr\Http\Client\Client_Interface;
use Psr\Http\Client\Network_Exception_Interface;
use Psr\Http\Client\Request_Exception_Interface;
use Psr\Http\Message\Request_Interface;
use Psr\Http\Message\Response_Interface;

/**
 * A simple API client that wraps any PSR-18 HTTP client.
 */
final class Json_Api_Client
{
    public function __construct(
        private readonly Client_Interface $http,
    ) {}

    /**
     * Fetch a JSON resource and return the decoded array.
     *
     * @param Request_Interface $request A fully-formed PSR-7 request.
     * @return array<string, mixed>
     * @throws \RuntimeException On network failure or non-2xx response.
     */
    public function fetch(Request_Interface $request): array
    {
        try {
            $response = $this->http->send_request($request);
        } catch (Network_Exception_Interface $e) {
            // Transport failure — safe to retry with back-off.
            throw new \RuntimeException(
                'Network error: ' . $e->getMessage(),
                0,
                $e,
            );
        } catch (Request_Exception_Interface $e) {
            // Request is malformed — do NOT retry.
            throw new \RuntimeException(
                'Bad request: ' . $e->getMessage(),
                0,
                $e,
            );
        }

        // HTTP errors (4xx, 5xx) are NOT exceptions in PSR-18.
        // Check the status code explicitly.
        $status = $response->get_status_code();
        if ($status < 200 || $status >= 300) {
            throw new \RuntimeException(
                "API returned HTTP {$status}: " . $response->get_reason_phrase(),
            );
        }

        $body = (string) $response->get_body();
        return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }
}

// --- Middleware decorator: automatic retry on network errors ---

final class Retry_Client implements Client_Interface
{
    public function __construct(
        private readonly Client_Interface $inner,
        private readonly int $max_retries = 3,
    ) {}

    public function send_request(Request_Interface $request): Response_Interface
    {
        $attempts = 0;
        while (true) {
            try {
                return $this->inner->send_request($request);
            } catch (Network_Exception_Interface $e) {
                if (++$attempts >= $this->max_retries) {
                    throw $e;
                }
                // In production, add exponential back-off here.
            }
        }
    }
}
