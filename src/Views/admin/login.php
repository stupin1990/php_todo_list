<div class="mx-2">
    <h4>Login</h4>

    <?php if ($errors) { ?>
    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div><?= $error ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php } ?>

    <form action="<?= $url ?>" method="POST">
        <div class="mb-3">
            <label for="user" class="form-label">User</label>
            <input type="text" name="user" class="form-control" id="user" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>