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
                <h3>Nueva tarea</h3>
                <textarea name="description" id="task" cols="30" rows="5"></textarea>
                <div class="wrap-option">
                    <input type="date" name="date_finish"> 
                    <input type="submit" value="+">
                </div>
                <input type="hidden" name="c" value="task">
                <input type="hidden" name="m" value="save">
            </form>

            <!-- Task section -->
            <section class="tasks">
                <span class="text-info">Tasks: <?= $count ?></span>

                <div class="list">
                <?php foreach($tasks as $task): ?>
                    <?php if(!$task['finished']):  ?>
                    <div class="item">
                        <div class="task">
                            <p>
                                <?= $task['description'] ?>
                            </p>

                            <div class="date-wrap">
                                <span class="date date-info">
                                    Agregada:<?= $task['date_added'] ?>
                                </span>

                                <?php 
                                    $date_finish = $task['date_finish'];

                                    $timeFinish = strtotime($date_finish);
                                    $timeNow = time(); 

                                if($timeNow >= $timeFinish):
                                ?>
                                    <span class="date date-danger">
                                        Finaliza:<?= $task['date_finish'] ?>
                                    </span>
                                <?php endif;?>

                                <?php if($timeNow < $timeFinish):?>
                                    <span class="date date-green">
                                        Finaliza:<?= $task['date_finish'] ?>
                                    </span>

                                <?php endif;?>
                            </div>
                        </div>

                        <div class="options">
                            <a href="index.php?c=task&m=delete&id=<?= $task['id']?>"><img src="assets/img/trash-icon.png"/></a>
                            <a href="index.php?c=task&m=updateForm&id=<?= $task['id']?>"><img src="assets/img/update-icon.png"/></a>
                            <a href="index.php?c=task&m=finish&id=<?= $task['id']?>"><img src="assets/img/checkmark.png"/></a>
                        </div>
                    </div>
                    <?php endif;?>
                <?php endforeach; ?>
                </div>
            </section>
        </div>
    </section>
    <footer id="footer">
        <div class="info">
            <span>Created By Alexander</span> <a target="_blank" href="http://github.com/alexander-ctrl"><img src="https://img.icons8.com/fluent/48/000000/github.png"/></a>
        </div>
    </footer>
</body>
</html>

