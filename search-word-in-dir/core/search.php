<?php

include_once("printter.php");

class Seeker{

    private $printter;
    public function __construct()
    {
        $this->printter = new Printter();
    }

    public function search(string $base, string $value)
    {
        $this->searchImpl($base, $value);
    }


    private function searchImpl(string $base, string $valuesearch)
    {
        foreach (new DirectoryIterator($base) as $file) {
            if($file->isDot()) continue;
            $filepath = $file->getPathname();

            if (is_dir($filepath)) {
                $this->searchImpl($filepath, $valuesearch);
            } else {
                $this->printPosIfExists($file, $valuesearch);
            }
        }
    }

    private function printPosIfExists($file, $valuesearch)
    {
        $readPermission = $this->checkPermissions($file);
        if(!$readPermission){
            echo "You don't have read permission to: " . $file->getPathname() . "\n"; 
            return;
        }

        $lines = fopen($file, "r") or die("Error opening file: " . $file->getPathname());

        $key = 1;
        $headerPrintter = false;
        while(!feof($lines)){

            $line = fgets($lines);
            $pos = strpos($line, $valuesearch);

            if($pos !== false){
                if(!$headerPrintter){
                    $this->printter->printHeader($file);
                    $headerPrintter = true;
                }

                $this->printter->printline($line, $key);
            }
            $key++;
        }
    }

    public function checkPermissions($file)
    {
        return is_readable($file);
    }

}