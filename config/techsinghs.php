<?php

declare(strict_types=1);

return [
    'api_key'   => env('TECHSINGHS_API_KEY', ''),
    'timeout'   => (float) env('TECHSINGHS_CLIENT_TIMEOUT', 5.0),
    'enabled'   => (bool) env('TECHSINGHS_ENABLED', false),
];
