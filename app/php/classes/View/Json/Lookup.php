<?php

namespace pedroac\whocalls\View\Json;

class Lookup implements \pedroac\whocalls\View\Lookup
{
    public function __construct()
    {
    }

    public function show(\pedroac\whocalls\Model\Lookup $model)
    {
        echo json_encode(
            [
                'phone' => (string)$model->getPhoneNumber(),
                'owner' => $model->getOwnerName(),
            ]
        );
    }
}