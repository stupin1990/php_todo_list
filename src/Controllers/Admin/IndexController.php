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
                $data = $this->prepareSaveData($fields, $_POST['new_task']);
                if (!count($data['errors'])) {
                    $errors = Task::add($fields, $data['params']);
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
                    $update = $this->prepareSaveData($fields, $data);
                    if (!count($update['errors'])) {
                        $update['params'] = 
                        $_errors = Task::update($id, $fields, $update['params']);
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