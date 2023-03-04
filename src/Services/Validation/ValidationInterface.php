<?php

namespace Src\Services\Validation;

interface ValidationInterface
{
    public static function getInstance();

    public function validate(string $field, $value): array;
}
