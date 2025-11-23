<?php

namespace App\Support;

use Closure;
use Exception;

class Api
{
    public function __construct(
        protected $raw = null,
        protected array $body = [],
        protected array $router = [],
        protected array $input = [],
        protected array $headers = [],
        protected ?string $method = null
    ) {}

    public function get($action)
    {
        if (! class_exists($action)) {
            throw new Exception(sprintf('Unknown class %s', $action));
        }

        $this->router['get'] = new $action;
    }

    public function post($action)
    {
        if (! class_exists($action)) {
            throw new Exception(sprintf('Unknown class %s', $action));
        }

        $this->router['post'] = new $action;
    }

    public function patch($action)
    {
        if (! class_exists($action)) {
            throw new Exception(sprintf('Unknown class %s', $action));
        }

        $this->router['patch'] = new $action;
    }

    public function delete($action)
    {
        if (! class_exists($action)) {
            throw new Exception(sprintf('Unknown class %s', $action));
        }

        $this->router['delete'] = new $action;
    }

    public function notFound()
    {
        http_response_code(404);

        return null;
    }

    public function sendResponse()
    {
        return match (true) {
            $this->isGet()
                && ! is_null($this->router['get'] ?? null) => $this->router['get'](
                    [...$this->getInput(), ...$this->getBody()]
                ),

            $this->isPost()
                && ! is_null($this->router['post'] ?? null) => $this->router['post'](
                    [...$this->getInput(), ...$this->getBody()]
                ),

            $this->isDelete()
                && ! is_null($this->router['delete'] ?? null) => $this->router['delete'](
                    [...$this->getInput(), ...$this->getBody()]
                ),
            default => $this->notFound()
        };
    }

    public static function capture(Closure $callback)
    {
        $router = (new static)
            ->sendResponseHeaders()
            ->captureHeaders()
            ->captureMethod()
            ->captureInput()
            ->captureBody();

        echo $router->sendResponse($callback($router));
    }

    public function sendResponseHeaders()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Allow-Methods: POST, PATCH, DELETE, OPTIONS');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        return $this;
    }

    public function captureHeaders()
    {
        return $this->setHeaders(getallheaders());
    }

    public function captureInput()
    {
        $this->input = array_merge($_POST, $_GET);

        return $this;
    }

    public function wantsJson() {}

    public function isJson(): bool
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        return strpos($contentType, 'application/json') !== false;
    }

    public function captureBody()
    {
        $this->raw = file_get_contents('php://input');

        if ($this->isJson()) {
            return $this->setBody(json_decode($this->raw ?? [], true) ?? []);
        } else {
            return $this->setBody($_POST);
        }

        return $this;
    }

    public function captureMethod()
    {
        return $this->setMethod($_SERVER['REQUEST_METHOD'] ?? null);
    }

    public function isPost(): bool
    {
        return strtolower($this->getMethod()) === 'post';
    }

    public function isPatch(): bool
    {
        return strtolower($this->getMethod()) === 'patch';
    }

    public function isGet(): bool
    {
        return strtolower($this->getMethod()) === 'get';
    }

    public function isDelete(): bool
    {
        return strtolower($this->getMethod()) === 'delete';
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function setBody(array $body = []): self
    {
        $this->body = $body;

        return $this;
    }

    public function getInput(): array
    {
        return $this->input;
    }

    public function setInput(array $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getRouter(): array
    {
        return $this->router;
    }
}
