<?php

namespace MobiMarket\TechSinghs\Requests;

use MobiMarket\TechSinghs\Exceptions\InvalidImeisException;

class BaseRequest
{
    public $ServiceId = 5;

    public function setServiceId(int $serviceId): void
    {
        $this->ServiceId = $serviceId;
    }

    public function toArray(): array
    {
        return (array) $this;
    }

    /**
     * performs very basic IMEI validation
     */
    public function validateImei(string $imei): bool
    {
        if (empty($imei)) {
            throw new InvalidImeisException('IMEI cannot be empty');
        }

        if (!preg_match('/^[0-9]{15,17}$/', $imei)) {
            throw new InvalidImeisException("IMEI '{$imei}' is not valid");
        }

        return true;
    }
}
