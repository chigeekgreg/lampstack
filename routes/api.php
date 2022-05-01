<?php
/**
 * Send an associative array as output. If the array contains a property named status, set the http status code to it.
 * 
 * @param array_result an associative array that may or may not contain a key named status
 * @param status HTTP status
 */
function send_json(array $array_result, ?int $status = NULL) {
    if(!is_null($status))
        http_response_code($status);
    elseif(isset($array_result['status']))
        http_response_code($array_result['status']);
    //else
    //    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode($array_result) . "\n");
}

include_once '../controllers/test.php';
$test = new TestController("test");
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_SERVER['REQUEST_URI']) {
            case '/api/test':
            case '/api/test/':
                send_json($test->index());
                break;
        }
        break;
    case 'POST':
        switch ($_SERVER['REQUEST_URI']) {
            case '/api/test/new':
                send_json($test->insert($test->process_multipart_params($_POST)));
                break;
            case '/api/test/update':
                send_json($test->update($test->process_multipart_params($_POST)));
                break;
            case '/api/test/delete':
                send_json($test->delete($test->process_multipart_params($_POST)));
                break;
        }
        break;
}
?>