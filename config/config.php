<?php
$config = [
    'db' => [
        'host' => 'db',
        'name' => 'lampstack',
        'user' => 'lampstack',
        'pass' => 'Changeme!',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ]
];
?>
