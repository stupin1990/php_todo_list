<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\Task;
use Src\Services\Validation\TaskValidation;

class AppController extends Controller
{
    public function index()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fields = ['name', 'email', 'post'];
            list($errors, $params) = $this->prepareSaveData($fields, $_POST, TaskValidation::getInstance());
            if (!count($errors) && !Task::save($fields, $params)) {
                $errors = "Failed to save data!";
            }
            if (!count($errors)) {
                header("Location: /?success=1");
                die;
            }
        }

        $sort_by = $_GET['sort'] ?? '';

        $tasks = Task::selectPaginate(['name', 'email', 'post', 'done', 'updated_by'], $this->page, $sort_by, $this->per_page);

        $this->render('index', [
            'tasks' => $tasks,
            'success' => $_GET['success'] ?? 0,
            'errors' => $errors,
            'sort_ar' => Task::$sort_ar,
            'sort' => $sort_by
        ]);
    }
}
