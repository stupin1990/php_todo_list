<div class="mx-2">
    <h4>Tasks</h4>

    <?php if ($success) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div>Task was added!</div>   
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <?php if ($errors) { ?>
    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div><?= $error ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php } ?>

    <div class="card-20">
    <form action="/" method="GET">
    <select class="form-select" name="sort" onchange="submit()">
        <?php foreach ($sort_ar as $sort_val => $sort_name) { ?>
        <option value="<?= $sort_val ?>" <?= $sort_val == $sort ? 'selected' : '' ?>><?= $sort_name ?></option>
        <?php } ?>
    </select>
    </form>
    </div>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 mx-0">
    <?php if ($tasks['total']) { ?>
        <?php foreach ($tasks['data'] as $task) { ?>
            <div class="col-4 card me-2 mt-2 card-20">
                <div class="card-body">
                    <h5 class="card-title"><?= $task['name'] ?></h5>
                    <h5 class="card-title"><?= $task['email'] ?></h5>
                    <p class="card-text"><?= $task['post'] ?></p>
                    <span class="badge text-bg-<?= $task['done'] ? 'success' : 'danger' ?>"><?= $task['done'] ? 'Done' : 'Undone' ?></span>
                    <?php if ($task['updated_by'] == 'admin') { ?>
                        <span class="badge text-bg-info">Updated by admin</span>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="alert alert-secondary" role="alert">
            There are no tasks!
        </div>
    <?php } ?>
    </div>

    <?php if ($tasks['pages'] > 1) { ?>
        <div class="mt-4">
        <?php $this->renderPartial('Components/pagination', [
            'pages' => $tasks['pages'],
            'current_page' => $tasks['current_page'],
            'next_page' => $tasks['next_page'],
            'prev_page' => $tasks['prev_page'],
            'per_page' => $tasks['per_page'],
            'total' => $tasks['total'],
            'url' => $url
        ]) ?>
        </div>
    <?php } ?>

    <h4>Add new task</a></h4>

    <form action="/" method="POST" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">User name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">User Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
            <label for="post" class="form-label">Post</label>
            <textarea class="form-control" name="post" required></textarea>
        </div>
    
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

</div>
