<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Sql Module</title>
</head>
<body>
    
    <?php
        require_once("MysqlQuery.php");
        require_once("Connection.php");

        $cn = new Connection();
        $query = new MysqslQuery($cn);

        echo "Select<br>";
        $result = $query->select("users", ['name', 'lastname']);
        echo "<pre>";
        var_dump($result);
        echo "</pre>";

        echo "<br>";
        $dataUpdate = [
            "name" => [
                "value" => "alexupdate",
                "type" => "string"
            ],
            "lastname" => [
                "value" => "alexupdate",
                "type" => "string"
            ],
        ];

        echo "Update<br>";
        $ok = $query->update("users", $dataUpdate); 
        echo "ok = " . $ok;

        echo "<br>";
        $dataInsert = [
            "name" => [
                "value" => "jorge",
                "type" => "string"
            ],
            "lastname" => [
                "value" => "luis",
                "type" => "string"
            ],
        ];

        echo "Insert<br>";
        $ok = $query->insert("users", $dataInsert);
        echo "ok = " . $ok;

    ?>
</body>
</html>