<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo $title ?>
        </title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/main.css" rel="stylesheet">
    </head>
  <body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="/"><?php echo $title ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/admin">Admin</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>
    <div id="content" class="container mt-2">
        <?php $this->renderPartial($template_name, $data) ?>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>