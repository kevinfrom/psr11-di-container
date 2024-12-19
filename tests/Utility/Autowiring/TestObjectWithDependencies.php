<?php

namespace Kevinfrom\DIContainer\Tests\Utility\Autowiring;

final readonly class TestObjectWithDependencies
{
    public function __construct(TestClass $testClass)
    {
    }
}
