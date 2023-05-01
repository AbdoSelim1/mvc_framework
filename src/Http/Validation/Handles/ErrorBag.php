<?php

namespace Src\Http\Validation\Handles;

class ErrorBag
{
    private array $errors = [];

    public function append(string $field, string  $massage): self
    {
        $this->errors[$field][] = $massage;
        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getError(string $field): string
    {

        return $this->errors[$field][0] ?? "";
    }
}
