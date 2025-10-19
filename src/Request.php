<?php

namespace Teardrops\Teardrops;

class Request
{
    private string $uri;
    private string $method;
    private array $parameters = [];
    private string $referer;

    public function __construct()
    {
        $this->uri = strval($_SERVER['REQUEST_URI']);
        $this->method = strval($_SERVER['REQUEST_METHOD']);
        $this->parameters = $_REQUEST;
        $this->referer = $_SERVER['HTTP_REFERER'] ?? '';
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function parameter(?string $key): array|string|null
    {
        if ($key === null) {
            return $this->parameters;
        }

        return $this->parameters[$key] ?? [];
    }

    public function json(?string $key): array|string|null
    {
        $body = file_get_contents('php://input');

        if (! $body) {
            return null;
        }

        $jsonData = json_decode($body, true);

        if (! $jsonData) {
            return null;
        }

        if ($key === null) {
            /** @var array $jsonData */
            return $jsonData;
        }

        /** @var array $jsonData */
        return $jsonData[$key];
    }

    public function validate(array $validationRules): void
    {
        $errors = [];
        
        foreach ($this->parameters as $key => $value) {
            if (isset($validationRules[$key])) {
                $rules = explode('|', $validationRules[$key]);

                foreach ($rules as $rule) {
                    if ($rule === 'required' && (is_null($value) || $value === '')) {
                        $errors[$key] = 'This field is required.';
                        continue 2;
                    }

                    if (str_starts_with($rule, 'min:')) {
                        $minLength = (int) substr($rule, 4);
                        if (strlen($value) < $minLength) {
                            $errors[$key] = "This field must be at least $minLength characters long.";
                            continue 2;
                        }
                    }

                    if (str_starts_with($rule, 'max:')) {
                        $maxLength = (int) substr($rule, 4);
                        if (strlen($value) > $maxLength) {
                            $errors[$key] = "This field must be lower than $maxLength characters long.";
                            continue 2;
                        }
                    }
                }
            }
        }
        
        if (! empty($errors)) {
            Response::redirect($this->referer)
                ->withErrors($errors)
                ->withOldData($this->parameters)
                ->send();
            exit;
        }

        return;
    }
}
