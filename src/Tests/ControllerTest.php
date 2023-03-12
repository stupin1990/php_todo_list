<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Src\Core\Controller;
use Src\Services\Validation\TaskValidation;

final class ControllerTest extends TestCase
{
    public function testPrepareSaveData(): void
    {
        $fields = ['name', 'email', 'post'];
        $data = [
            'name' => 'Name',
            'email' => 'name@mail.com',
            'post' => 'task post',
            'other' => 'Other',   
        ];

        $controller = new Controller;

        $result = $controller->prepareSaveData($fields, $data, TaskValidation::getInstance());

        $this->assertSame(2, count($result));

        list($errors, $params) = $result;

        $this->assertSame(count($fields), count($params));

        foreach ($fields as $field) {
            $this->assertArrayHasKey(':' . $field, $params);
            $this->assertSame($data[$field], $params[':' . $field]);
        }

        $this->assertSame(0, count($errors));
    }
}
