<?php

namespace Kevinfrom\DIContainer\Tests\Utility\Autowiring;

final readonly class TestObjectWithPrivateConstructor
{
    private function __construct(TestClass $testClass)
    {
    }
}
