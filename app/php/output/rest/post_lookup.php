<?php
/**
 * method: POST
 * resource: A phone number lookup with a specified phone number
 * var: $phone_number A phone number.
 * param: owner The owner name that should be changed.
 */

include_once __DIR__ . '/init.php';

$repository = new \pedroac\whocalls\Controller\Lookup(
    new \pedroac\whocalls\View\Json\Lookup
);
http_response_code(200);
header('Content-Type: application/json');
$repository->post(
    $phone_number,
    $params
);