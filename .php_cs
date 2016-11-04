<?php

require_once __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

return ConfigBridge::create(null, [
    __DIR__.'/app',
    __DIR__.'/config',
    __DIR__.'/resources/lang',
    __DIR__.'/routes',
    __DIR__.'/tests',
]);