<?php

namespace Kevinfrom\DIContainer\Tests\Unit;

use Kevinfrom\DIContainer\AutowiringContainer;
use Kevinfrom\DIContainer\Tests\Utility\Autowiring\TestClass;
use Kevinfrom\DIContainer\Tests\Utility\Autowiring\TestObjectWithDeeperDependencies;
use Kevinfrom\DIContainer\Tests\Utility\Autowiring\TestObjectWithDependencies;
use Kevinfrom\DIContainer\Tests\Utility\Autowiring\TestObjectWithPrivateConstructor;
use Kevinfrom\DIContainer\Tests\Utility\TestObject;
use PHPUnit\Framework\TestCase;

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

    public function test_it_can_resolve_a_class_from_invoker_cache(): void
    {
        $container = new AutowiringContainer();

        $this->assertInstanceOf(TestObjectWithDependencies::class, $container->get(TestObjectWithDependencies::class));
        $this->assertInstanceOf(TestObjectWithDependencies::class, $container->get(TestObjectWithDependencies::class));
    }

    public function test_it_cannot_resolve_a_class_that_is_not_instantiable(): void
    {
        $this->expectExceptionMessage('Could not find service with id: ' . TestObjectWithPrivateConstructor::class);
        $container = new AutowiringContainer();
        $container->get(TestObjectWithPrivateConstructor::class);
    }
}
