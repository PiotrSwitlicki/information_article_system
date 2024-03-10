<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }
}
