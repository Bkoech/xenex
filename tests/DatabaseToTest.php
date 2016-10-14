<?php

trait DatabaseToTest
{
    public function initDatabase()
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function resetDatabase()
    {
        Artisan::call('migrate:reset');
    }
}
