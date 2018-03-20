<?php

$routes = [
    [
        '~api/lookups/(?P<phone_number>[^/]+)~i',
        [
            'GET'  => 'rest/get_lookup',
            'POST' => 'rest/post_lookup',
        ]
    ]
];

$path = 'api/lookups/%2B351967014652';
$method = 'GET'; //strtoupper($_SERVER['REQUEST_METHOD']);
$params = ($method == 'GET') ? $_GET : $_POST; 
foreach ($routes as $route) {
    $matches = null;
    if (preg_match($route[0], $path, $matches)) {
        if (isset($route[1][$method])) {
            (
                function($file, $vars, $params) {
                    extract(array_map('urldecode', $vars));
                    $params = $_POST;
                    include __DIR__ . '/output/' . $file. '.php';
                }
            )($route[1][$method], $matches, $params);
        }
        break;
    }
}