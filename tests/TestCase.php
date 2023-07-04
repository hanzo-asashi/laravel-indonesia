<?php

namespace HanzoAsashi\Indonesia\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use HanzoAsashi\Indonesia\IndonesiaServiceProvider;

/**
 * @see https://packages.tools/testbench/basic/testcase.html
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use DatabaseTransactions;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     Artisan::call('migrate');
    //     Artisan::call('db:seed', [
    //         'class' => \KodePandai\Indonesia\IndonesiaDatabaseSeeder::class,
    //     ]);
    // }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [IndonesiaServiceProvider::class];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetup($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => 'database.sqlite',
        ]);
    }
}
