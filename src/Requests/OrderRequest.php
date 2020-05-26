<?php

namespace MobiMarket\TechSinghs\Requests;

use MobiMarket\TechSinghs\Requests\BaseRequest;

class OrderRequest extends BaseRequest
{
    public $Imei;

    public function setImei(string $imei): void
    {
        $this->validateImei($imei);

        $this->Imei = $imei;
    }
}
