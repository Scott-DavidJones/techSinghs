<?php

namespace MobiMarket\TechSinghs\Requests;

use MobiMarket\TechSinghs\Requests\BaseRequest;

class BatchRequest extends BaseRequest
{
    public $ImeiList;

    public function setImeiList(array $imeis): void
    {
        // basic IMEI validation
        foreach ($imeis as $imei) {
            $this->validateImei($imei);
        }

        $this->ImeiList = $imeis;
    }
}
