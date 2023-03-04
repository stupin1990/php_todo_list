<?php

namespace Src\Services\Validation;

abstract class Validation implements ValidationInterface
{
    public array $fields;

    private static $instance;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance =  new static();
        }

        return static::$instance;
    }

    public function validate(string $field, $value): array
    {
        $result = [
            'error' => '',
            'value' => $value
        ];
        //print_r($this->fields); die;
        //echo $field . ' ' . $value . '<br>';

        if (!isset($this->fields[$field])) {
            return $result;
        }

        $type = explode(':', $this->fields[$field]['type']);
        $length = isset($type[1]) ? (int)$type[1] : 0;
        $type = ucfirst($type[0]);
        $name = $this->fields[$field]['name'];

        $function = "validate$type";

        //echo $function . ' ' . $value . '<br';
        try {
            list($error, $value) = $this->$function($field, $value, $length);
            $result['error'] = str_replace('{field}', $name, $error);
            $result['value'] = $value;
        } catch (\Exception $e) {
        }

        return  $result;
    }

    protected function validateText(string $field, $value, int $length): array
    {
        $error = '';
        if ($length && strlen($value) > $length) {
            $error = "Field '{field}' is too long, max: $length";
        }
        return [$error, htmlentities($value)];
    }

    protected function validateEmail(string $field, $value, int $length): array
    {
        $error = '';
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $error =  "'{field}' is invalid email address.";
            return [$error, htmlentities($value)];
        }
        return $this->validateText($field, $value, $length);
    }

    protected function validateCheckbox(string $field, $value, int $length = 0): array
    {
        $value = !$value ? 0 : 1;
        return ['', $value];
    }
}
