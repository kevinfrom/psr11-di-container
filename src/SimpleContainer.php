<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

final class SimpleContainer implements ContainerInterface
{
    /* @var array<class-string, callable> $invokers */
    private array $invokers = [];

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->has($id) === false) {
            throw new NotFoundException("Could not find service with id: $id");
        }

        return call_user_func($this->invokers[$id]);
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->invokers[$id]);
    }

    /**
     * Register a service
     *
     * @param string   $id
     * @param callable $invoker
     *
     * @return self
     */
    public function register(string $id, callable $invoker): self
    {
        $this->invokers[$id] = $invoker;

        return $this;
    }

    /**
     * Register a singleton service
     *
     * @param string   $id
     * @param callable $invoker
     *
     * @return $this
     */
    public function registerSingleton(string $id, callable $invoker): self
    {
        $this->register($id, function () use ($invoker) {
            static $instance;

            if ($instance === null) {
                $instance = call_user_func($invoker);
            }

            return $instance;
        });

        return $this;
    }
}
