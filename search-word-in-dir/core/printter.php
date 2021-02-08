<?php

class Printter {

    private $counter = 0;

    public function printline($line, $linenumb)
    {

        $message = "Line: " . $linenumb + 1 . "\n";
        $message .= "------------------------------\n";
        $message .= $line . "\n"; 
        $message .= "------------------------------\n";

        $this->counter++;
        $message .= "Count: ".$this->counter . "\n";
        echo $message;

        echo "\n\n";
    }

    public function printHeader($file)
    {
        $header = "Filename: " . $file->getFileName() . "\n"; 
        $header .= "Path: " . $file->getPathname() . "\n";

        echo $header;
    }
}