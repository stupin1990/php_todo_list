<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Src\Services\Validation\TaskValidation;

final class ValidationTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testPrepareSaveData(string $type, string $field, string $value): void
    {
        $validator = TaskValidation::getInstance();

        $errors = $params = [];
        
        $result = $validator->validate($field, $value);

        $this->assertSame(2, count($result));

        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('value', $result);

        if ($type == 'ok') {
            $this->assertSame(0, strlen($result['error']));
        }
        elseif ($type == 'error') {
            $this->assertGreaterThan(0, strlen($result['error']));
        }
    }

    public function dataProvider(): array
    {
        return [
            ['ok', 'name', 'Name'],
            ['ok','email', 'name@mail.com'],
            ['ok','post', 'text'],
            ['error', 'name', ''],
            ['error', 'name', '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'],
            ['error','email', 'name@mail'],
            ['error','post', ''],
        ];
    }
}
