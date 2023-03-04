<div class="mx-2">
    <h4>Edit tasks</h4>

    <?php $this->renderPartial('/Components/alerts', [
        'success' => $success,
        'errors' => $errors,
    ]) ?>

    <div class="card-20">
        <?php $this->renderPartial('/Components/sort_block', [
            'url' => $url,
            'sort_ar' => $sort_ar,
            'sort' => $sort
        ]) ?>
    </div>
    
    <div class="d-flex mt-2 mb-4">
    <?php if ($tasks['total']) { ?>
        <form action="<?= $url ?>" method="POST">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Post</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
        <?php foreach ($tasks['data'] as $task) { ?>
            <tr>
                <td><?= $task['id'] ?></th>
                <td><input type="text" name="task[<?= $task['id'] ?>][name]" class="form-control" value="<?= $task['name'] ?>" required></td>
                <td><input type="email" name="task[<?= $task['id'] ?>][email]" class="form-control" value="<?= $task['email'] ?>" required></td>
                <td>
                    <textarea class="form-control" name="task[<?= $task['id'] ?>][post]" required><?= $task['post'] ?></textarea>
                    <div class="form-check">
                        <input type="checkbox" id="done_<?= $task['id'] ?>" name="task[<?= $task['id'] ?>][done]" value="1" <?= $task['done'] ? ' checked' : '' ?>>
                        <label class="form-check-label" for="done_<?= $task['id'] ?>">Done</label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" name="task[<?= $task['id'] ?>][delete]" value="1">
                    </div>
                </td>
            </tr>
        <?php } ?>
        </table>
        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    <?php } else { ?>
        <div class="alert alert-secondary" role="alert">
            There are no tasks!
        </div>
    <?php } ?>
    </div>

    <?php if ($tasks['pages'] > 1) { ?>
        <?php $this->renderPartial('/Components/pagination', [
            'pages' => $tasks['pages'],
            'current_page' => $tasks['current_page'],
            'next_page' => $tasks['next_page'],
            'prev_page' => $tasks['prev_page'],
            'per_page' => $tasks['per_page'],
            'total' => $tasks['total'],
            'url' => $url
        ]) ?>
    <?php } ?>

    <h4>Add new task</a></h4>
        
    <?php $this->renderPartial('/Components/add_form', [
        'url' => $url,
        'show_done' => 1
    ]) ?>

</div>