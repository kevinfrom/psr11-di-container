<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Tests\Utility\TestObjectWithDeeperDependencies;
use Psr\Container\ContainerInterface;
use ReflectionClass;

final class AutowiringContainer implements ContainerInterface
{
    /* @var array<class-string, callable> */
    private array $invokers = [];

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        return call_user_func($this->resolve($id));
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function has(string $id): bool
    {
        if (isset($this->invokers[$id])) {
            return true;
        }

        $invoker = $this->resolve($id);

        if ($invoker === null) {
            return false;
        }

        $this->invokers[$id] = $invoker;

        return true;
    }

    /**
     * Resolve the invoker for the given class name.
     *
     * @param string $id
     *
     * @return callable|null
     * @throws \ReflectionException
     */
    private function resolve(string $id): ?callable
    {
        $reflectionClass = new ReflectionClass($id);

        if ($reflectionClass->isInstantiable() === false) {
            return null;
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return fn() => new $id();
        }

        $parameters = $constructor->getParameters();

        $dependencies = array_map(function ($parameter) {
            return $parameter->getType()->getName();
        }, $parameters);

        return function () use ($id, $dependencies) {
            return new $id(...array_map(fn($dependency) => $this->get($dependency), $dependencies));
        };
    }

    public function test_it_can_resolve_a_class_with_deeper_dependencies(): void
    {
        $container = new AutowiringContainer();

        $this->assertInstanceOf(TestObjectWithDeeperDependencies::class, $container->get(TestObjectWithDeeperDependencies::class));
    }
}
