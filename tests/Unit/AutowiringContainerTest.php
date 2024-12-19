<?php

namespace Kevinfrom\DIContainer\Tests\Unit;

use Kevinfrom\DIContainer\Tests\Utility\TestClass;
use Kevinfrom\DIContainer\Tests\Utility\TestObject;
use Kevinfrom\DIContainer\Tests\Utility\TestObjectWithDeeperDependencies;
use Kevinfrom\DIContainer\Tests\Utility\TestObjectWithDependencies;
use PHPUnit\Framework\TestCase;
use Kevinfrom\DIContainer\AutowiringContainer;

final class AutowiringContainerTest extends TestCase
{
    use TestObject;

    public function test_it_can_resolve_a_class_without_dependencies(): void
    {
        $container = new AutowiringContainer();

        $this->assertInstanceOf(TestClass::class, $container->get(TestClass::class));
    }

    public function test_it_can_resolve_a_class_with_dependencies(): void
    {
        $container = new AutowiringContainer();

        $this->assertInstanceOf(TestObjectWithDependencies::class, $container->get(TestObjectWithDependencies::class));
    }

    public function test_it_can_resolve_a_class_with_deeper_dependencies(): void
    {
        $container = new AutowiringContainer();

        $this->assertInstanceOf(TestObjectWithDeeperDependencies::class, $container->get(TestObjectWithDeeperDependencies::class));
    }

    public function test_it_throws_not_found_exception_when_class_cannot_be_resolved(): void
    {
        $this->expectExceptionMessage('Could not find service with id: NonExistingClass');
        $container = new AutowiringContainer();
        $container->get('NonExistingClass');
    }
}
