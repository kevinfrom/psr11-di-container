<?php

namespace Kevinfrom\DIContainer\Tests\Utility\Autowiring;

final readonly class TestObjectWithDeeperDependencies
{
    public function __construct(TestObjectWithDependencies $testObjectWithDependencies)
    {
    }
}
