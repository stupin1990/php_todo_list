<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\Task;

class AppController extends Controller
{
    public function index()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fields = ['name', 'email', 'post'];
            $data = $this->prepareSaveData($fields, $_POST);
            if (!count($data['errors'])) {
                $errors = Task::add($fields, $data['params']);
            }
            if (!count($errors)) {
                header("Location: /?success=1");
                die;
            }
        }

        $sort = !empty($_GET['sort']) ? $_GET['sort'] : 'id_desc';
        if (!isset(Task::$sort_ar[$sort])) {
            $sort = 'id_desc';
        }
        $order_by = strtoupper(str_replace('_', ' ', $sort));

        $tasks = Task::selectPaginate(['name', 'email', 'post', 'done', 'updated_by'], $this->page, $order_by, $this->per_page);

        $this->render('index', [
            'tasks' => $tasks,
            'success' => $_GET['success'] ?? 0,
            'errors' => $errors,
            'sort_ar' => Task::$sort_ar,
            'sort' => $sort
        ]);
    }
}