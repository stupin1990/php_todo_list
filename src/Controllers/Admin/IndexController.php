<?php

namespace Src\Controllers\Admin;

use Src\Core\AdminController;
use Src\Models\Task;

class IndexController extends AdminController
{
    public function index()
    {
        $errors = [];
        $fields = ['name', 'email', 'post', 'done', 'updated_by'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['new_task'])) {
                list($errors, $params) = $this->prepareSaveData($fields, $_POST['new_task']);
                if (!count($errors)) {
                    $errors = Task::add($fields, $params);
                }
                if (!count($errors)) {
                    header("Location: /admin/index?success=1");
                    die;
                }
            }
            else {
                $delete_ar = [];
                foreach ($_POST['task'] as $id => $data) {
                    if (isset($data['delete'])) {
                        $delete_ar[] = $id;
                        continue;
                    }
                    list($errors, $params) = $this->prepareSaveData($fields, $data);
                    if (!count($errors)) {
                        $_errors = Task::update($id, $fields, $params);
                        $errors = array_merge($errors, $_errors);
                    }
                }
                if (count($delete_ar) && !Task::delete($delete_ar)) {
                    $errors[] = 'Failed to delete data!';
                }
                if (!count($errors)) {
                    header("Location: /admin/index?success=1");
                    die;
                }
            }
        }

        $tasks = Task::selectPaginate(['id', 'name', 'email', 'post', 'done'], $this->page, '', $this->per_page);

        $this->render('admin/index', [
            'tasks' => $tasks,
            'success' => $_GET['success'] ?? 0,
            'errors' => $errors
        ]);
    }
}