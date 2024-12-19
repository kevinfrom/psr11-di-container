<?php

namespace Kevinfrom\DIContainer\Tests\Utility;

final readonly class TestObjectWithDeeperDependencies
{
    public function __construct(private readonly TestObjectWithDependencies $testObjectWithDependencies)
    {
    }
}