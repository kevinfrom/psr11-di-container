<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Exception\NotFoundException;
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
        if ($this->has($id) === false) {
            throw new NotFoundException("Could not find service with id: $id");
        }

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
        if (class_exists($id) === false) {
            return null;
        }

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
}
