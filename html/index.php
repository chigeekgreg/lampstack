<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <title>LAMP Stack Docker Example</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>LAMP Stack Docker Example</h1>
    <p>Example of a LAMP stack using docker-compose</p>
    <hr>
    <h2>Database test</h2>
    <!-- Run a simple `SELECT * FROM test` query and display the results. -->
<?php
include '../config/config.php';
try {
    $dsn = "mysql:host=$dbhost;dbname=$dbname";
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    echo "    <p>Database connection successful!</p>\n";
} catch (PDOException $e) {
    die("    <p>Connection to database failed: ${$e->getMessage()}</p>\n</body>\n</html>");
}
$sql = 'SELECT * FROM test';
try {
    $statement = $pdo->query($sql);
    if($statement && $statement->rowCount() > 0) {
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            echo <<<HTML
                <h3>${row['title']}</h2>
                <p>${row['message']}</p>
            
            HTML;
        }
    } else {
        echo "    <p>No results</p>\n";
    }
} catch (PDOException $e) {
    echo "    <p>Query error: ${$e->getMessage()}</p>\n";
}
?>
    <hr>
    <h2>PHP Info</h2>
    <iframe src="info.php" width=960 height=960></iframe>
</body>
</html>