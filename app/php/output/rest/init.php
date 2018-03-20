<?php

/**
 * Show an error message with JSON format.
 *
 * @param integer $httpCode HTTP code.
 * @param string $message Error message.
 * @return void
 */
function pac_show_json_error(int $httpCode, string $message)
{
    http_response_code($httpCode);
    header('Content-Type: application/json');
    echo json_encode(
        [
            'error' => $message
        ]
    );
}

set_error_handler(
    function() {
        pac_show_json_error(500, 'Internal server error.');
    }
);

set_exception_handler (
    function(\Throwable $exception) {
        if (get_class($exception) == 'pedroac\whocalls\HttpException') {
            pac_show_json_error(
                $exception->getCode(),
                $exception->getMessage()
            );
            return;
        }
        pac_show_json_error(500, 'Internal server error.');
    }
);