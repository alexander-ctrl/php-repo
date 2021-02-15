<?php

class ViewController {

    public function home()
    {
        header("Location: index.php?c=task&m=viewAll");
    }

}