<?php

namespace Kevinfrom\DIContainer\Tests\Unit;

use stdClass;
use Kevinfrom\DIContainer\SimpleContainer;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class SimpleContainerTest extends TestCase
{
    private function getTestObject(): stdClass
    {
        $object       = new stdClass();
        $object->name = 'Lorem Ipsum';

        return $object;
    }

    public function test_it_can_instantiate_container()
    {
        $container = new SimpleContainer();
        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function test_it_can_add_service()
    {
        $container = new SimpleContainer();
        $container->registerService('test', fn() => $this->getTestObject());
        $this->assertTrue($container->has('test'));
    }

    public function test_it_can_get_service()
    {
        $container = new SimpleContainer();
        $container->registerService('test', fn() => $this->getTestObject());
        $service = $container->get('test');
        $this->assertInstanceOf(stdClass::class, $service);
    }

    public function test_it_can_get_different_instance()
    {
        $container = new SimpleContainer();
        $container->registerService('test', fn() => $this->getTestObject());
        $service1 = $container->get('test');
        $service2 = $container->get('test');
        $this->assertNotSame($service1, $service2);
    }
}