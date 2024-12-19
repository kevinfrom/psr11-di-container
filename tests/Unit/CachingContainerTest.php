<?php

namespace Kevinfrom\DIContainer\Tests\Unit;

use Kevinfrom\DIContainer\Tests\LibraryTestCase;
use Kevinfrom\DIContainer\CachingContainer;
use stdClass;

final class CachingContainerTest extends LibraryTestCase
{
    public function test_it_can_register_a_service(): void
    {
        $container = new CachingContainer();
        $container->register('test', fn() => $this->getTestObject());

        $this->assertTrue($container->has('test'));
    }

    public function test_it_can_get_a_service(): void
    {
        $container = new CachingContainer();
        $container->register('test', fn() => $this->getTestObject());

        $this->assertInstanceOf(stdClass::class, $container->get('test'));
    }

    public function test_it_throws_an_exception_when_service_not_found(): void
    {
        $this->expectExceptionMessage('Could not find service with id: test');
        $container = new CachingContainer();
        $container->get('test');
    }

    public function test_it_can_clear_cache(): void
    {
        $container = new CachingContainer();
        $container->register('test', fn() => $this->getTestObject());
        $container->get('test');
        $this->assertEquals(1, $container->cacheCount());
        $container->clearCache();

        $this->assertEquals(0, $container->cacheCount());
    }

    public function test_it_can_get_a_service_from_cache(): void
    {
        $container = new CachingContainer();
        $container->register('test', fn() => $this->getTestObject());
        $a = $container->get('test');
        $b = $container->get('test');

        $this->assertEquals($a, $b);
    }

    public function test_it_can_register_a_singleton_service(): void
    {
        $container = new CachingContainer();
        $container->registerSingleton('test', fn() => $this->getTestObject());

        $this->assertTrue($container->has('test'));
    }

    public function test_it_can_get_a_singleton_service(): void
    {
        $container = new CachingContainer();
        $container->registerSingleton('test', fn() => $this->getTestObject());
        $a = $container->get('test');
        $b = $container->get('test');

        $this->assertEquals($a, $b);
    }
}