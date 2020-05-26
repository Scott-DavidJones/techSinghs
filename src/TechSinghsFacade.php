<?php

declare(strict_types=1);

namespace MobiMarket\TechSinghs;

use Illuminate\Support\Facades\Facade;

/**
 * @method object checkSingleImei(string $imei)
 * @method object initiateImeiBatch(array $imeis)
 * @method object getBatchResults(string $batchId)
 * @method object getAccountInfo()
 * @method object getServices()
 */
class TechSinghsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TechSinghs::class;
    }
}
