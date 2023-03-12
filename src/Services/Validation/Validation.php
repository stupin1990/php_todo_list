<?php

namespace Src\Services\Validation;

abstract class Validation implements ValidationInterface
{
    public array $fields;

    private static $instance;

    /**
     * Singleton object
     * @return Validation
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance =  new static();
        }

        return static::$instance;
    }

    /**
     * Main validation method
     * @param string $field
     * @param mixed $value
     * 
     * @return array [error => '', value = '']
     */
    public function validate(string $field, $value): array
    {
        $result = [
            'error' => '',
            'value' => $value
        ];

        if (!isset($this->fields[$field])) {
            return $result;
        }

        $type_ar = explode('|', $this->fields[$field]['type']);
        $functions = ['text', 'email', 'checkbox'];
        $min = $max = 0;
        foreach ($type_ar as $type_item) {
            if ($type_item == 'required') {
                $min = 1;
            }
            elseif( preg_match("/max\:([0-9]+)/", $type_item, $matches)) {
                $max = (int)$matches[1];
            }
            else {
                $function = "validate{$type_item}";
            }
        }

        $name = $this->fields[$field]['name'];

        try {
            list($error, $value) = $this->$function($field, $value, $min, $max);
            $result['error'] = str_replace('{field}', $name, $error);
            $result['value'] = $value;
        } catch (\Exception $e) {
        }

        return  $result;
    }

    /**
     * Text validation
     * @param string $field
     * @param mixed $value
     * @param int $min
     * @param int $max
     * 
     * @return array [error => '', value = '']
     */
    protected function validateText(string $field, $value, int $min, int $max): array
    {
        $error = '';
        if ($min && strlen($value) < $min) {
            $error = "Field '{field}' is " . ($min == 1 ? 'required.' : "too small, need $min characters.");
        }
        elseif ($max && strlen($value) > $max) {
            $error = "Field '{field}' is too long, max: $max.";
        }
        return [$error, htmlentities($value)];
    }

    /**
     * Email validation
     * @param string $field
     * @param mixed $value
     * @param int $min
     * @param int $max
     * 
     * @return array [error => '', value = '']
     */
    protected function validateEmail(string $field, $value, int $min, int $max): array
    {
        $error = '';
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $error =  "'{field}' is invalid email address.";
            return [$error, htmlentities($value)];
        }
        return $this->validateText($field, $value, $min, $max);
    }

    /**
     * Checkbox validation
     * @param string $field
     * @param mixed $value
     * @param int $min
     * @param int $max
     * 
     * @return array [error => '', value = '']
     */
    protected function validateCheckbox(string $field, $value, int $min = 0, int $max = 0): array
    {
        $value = !$value ? 0 : 1;
        return ['', $value];
    }
}
