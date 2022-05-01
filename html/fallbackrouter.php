<?php
// This fallback document is called if there is no matching file resource

// Try to match a custom route
if(strpos($_SERVER['REQUEST_URI'], '/api') === 0)
    include_once '../routes/api.php';
else
    include_once '../routes/pages.php';

// No matching route
http_response_code(404);
echo "Could not {$_SERVER['REQUEST_METHOD']} {$_SERVER['REQUEST_URI']} : not found.\n";
?>