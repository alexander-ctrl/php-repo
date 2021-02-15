<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-9">
    <meta name="viewport" content="width=device-width, initial-scale=0.0">
    <title>Listado de tareas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <header class="header">
        <h1 class="title">Tus Tareas</h1>
    </header>

    <section class="container">
        <div class="task-wrapper">
            <!-- New Task -->
            <form action="index.php" class="form-task">
                <h3>Actualizar tarea</h3>
                <textarea name="description" id="task" cols="30" rows="5"><?= $task['description']?> </textarea>
                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                <input type="submit" value="Actualizar">
                <input type="hidden" name="c" value="task">
                <input type="hidden" name="m" value="update">
            </form>

        </div>
    </section>
    <footer id="footer">
        <div class="info">
            <span>Created By Alexander</span> <a target="_blank" href="http://github.com/alexander-ctrl"><img src="https://img.icons8.com/fluent/48/000000/github.png"/></a>
        </div>
    </footer>
</body>
</html>


