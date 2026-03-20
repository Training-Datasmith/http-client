# Architecture: psr/http-client (PSR-18)

## Purpose

This package defines PSR-18: HTTP Client Interface. It provides a standard
contract for sending PSR-7 HTTP requests, enabling libraries to send HTTP
requests without coupling to a specific HTTP client implementation
(Guzzle, Symfony HttpClient, cURL wrapper, etc.).

## PSR Standard

**PSR-18** — https://www.php-fig.org/psr/psr-18/

## Directory Structure

```
src/
  Client_Interface.php            — Sends a PSR-7 request, returns a PSR-7 response
  Client_Exception_Interface.php  — Marker for all HTTP client exceptions
  Network_Exception_Interface.php — Thrown on transport-layer failures (no response)
  Request_Exception_Interface.php — Thrown for malformed, unsendable requests
```

## Key Design Decisions

### HTTP errors are responses, not exceptions
4xx and 5xx responses are valid HTTP. The client MUST return them as
`Response_Interface` objects. Consumers must check `get_status_code()` to
detect application-level errors. This mirrors how browsers and curl behave.

### Two exception categories
- `Network_Exception_Interface` — a transport failure; no response was received.
  Use this to trigger retry logic.
- `Request_Exception_Interface` — the request itself was invalid; do not retry.

Both extend `Client_Exception_Interface` as a common catch-all.

### Synchronous only
PSR-18 defines a synchronous, blocking API. Async/concurrent HTTP is outside
the scope of this standard and is provided by implementation-specific APIs.

### PSR-7 dependency
The interface depends on `psr/http-message` (PSR-7) for both the request and
response types. Any PSR-7 request can be sent with any PSR-18 client.

## Extension Points

- Implement `Client_Interface` to create a new HTTP client backend.
- Decorate `Client_Interface` to add middleware: logging, retry, caching, auth.
- Implement the exception interfaces with contextual data (request body,
  response status at failure) to aid debugging.

## Dependency Flow

```
Calling code
    └── Client_Interface  (injected)
            ├── Request_Interface  (PSR-7, passed in)
            └── Response_Interface (PSR-7, returned)
```
