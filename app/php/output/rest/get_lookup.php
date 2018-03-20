<?php
/**
 * method: GET
 * resource: A phone number lookup with a specified phone number.
 * var: $phone_number A phone number.
 */

//include_once __DIR__ . '/init.php';

$repository = new \pedroac\whocalls\Controller\Lookup(
    new \pedroac\whocalls\View\Json\Lookup
);
http_response_code(200);
header('Content-Type: application/json');
$repository->get($phone_number);
