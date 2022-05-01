<?php
/**
 * Send an associative array through a view as output. If the array contains a property named status, set the http status code to it.
 * 
 * @param view name of the view to use
 * @param array_result an associative array that may or may not contain a key named status
 * @param status HTTP status
 */
function send_view(string $view, array $array_result, ?int $status = NULL) {
    if(!is_null($status))
        http_response_code($status);
    elseif(isset($array_result['status']))
        http_response_code($array_result['status']);
    //else
    //    http_response_code(200);
    //header('Content-Type: text/html; charset=utf-8');
    if(!is_readable("../views/$view.php")) {
        http_response_code(500);
        die("Error: View $view does not exist.");
    }
    include_once "../views/$view.php";
    die("\n");
}
include_once '../controllers/test.php';
$test = new TestController("test");
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_SERVER['REQUEST_URI']) {
            case '/':
                send_view('index', $test->index());
                break;
        }
        break;
    break;
}
?>