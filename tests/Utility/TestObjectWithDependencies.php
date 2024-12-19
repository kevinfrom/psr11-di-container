<?php

namespace Kevinfrom\DIContainer\Tests\Utility;

final readonly class TestObjectWithDependencies
{
    public function __construct(private readonly TestClass $testClass)
    {
    }
}