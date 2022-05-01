<?php
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <title>Hello MVC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Hello MVC</h1>
    <p>
        This is an example of a very basic and stupid attempt to implement a design that somewhat resembles MVC,
        on a plain LAMP stack, with no external dependencies other than the PDO database driver for MariaDB,
        complete with fancy vanity routing and a basic RESTful CRUD API, made in a few hours instead of sleeping.
    </p>
    <hr>
    <h2>Page Routes</h2>
    <h3>GET</h3>
    <ul>
        <li>
            <details>
                <summary>/ - this view</summary>
                <strong>Example:</strong>
                <code>curl <?php echo $base_url; ?>/</code>
            </details>
        </li>
    </ul>
    <h3>POST</h3>
    <h2>API Routes</h2>
    <h3>GET</h3>
    <ul>
        <li>
            <details>
                <summary>/api/test - get the test table</summary>
                <strong>Example:</strong>
                <code>curl <?php echo $base_url; ?>/api/test</code>
            </details>
        </li>
    </ul>
    <h3>POST</h3>
    <ul>
        <li>
            <details>
                <summary>/api/test/new - create new items in the test table</summary>
                <strong>Example:</strong>
                <code>curl -F "title[]=foo title" -F "message[]=foo message" -F "title[]=bar title" -F "message[]=bar message" -X POST <?php echo $base_url; ?>/api/test/new</code>
            </details>
        </li>
        <li>
            <details>
                <summary>/api/test/update - update existing items in the test table, by ID</summary>
                <strong>Example:</strong>
                <code>curl -F "id[]=2" -F "title[]=frazz" -F "message[]=frazz message" -F "id[]=3" -F "title[]=matazz title" -F "message[]=matazz message" -X POST <?php echo $base_url; ?>/api/test/update</code>
            </details>
        </li>
        <li>
            <details>
                <summary>/api/test/delete - delete items from the test table, by any filter</summary>
                <strong>Example:</strong>
                <code>curl -F "id[]=2" -F "id[]=3" -X POST <?php echo $base_url; ?>/api/test/delete</code>
            </details>
        </li>
    </ul>
    <hr>
    <h2>Database test</h2>
    <!-- Run a simple `SELECT * FROM test` query and display the results. -->
<?php foreach ($array_result as $item):
    echo <<<HTML
    <div class="row">
        <h3>${item['title']}</h2>
        <p>${item['message']}</p>
    </div>
    HTML;
endforeach; ?>

</body>
</html>