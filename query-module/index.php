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
        $query->select("users", ['name', 'lastname']);

        echo "<br>";

        echo "Update<br>";
        $query->update("users", ['name' => "alex"]); 

        echo "<br>";

        echo "Insert<br>";
        $query->insert("users", ["name" => "alex", "lastname"=>"guzguz"]);

    ?>
</body>
</html>