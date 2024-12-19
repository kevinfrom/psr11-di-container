<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Exception\NotFoundException;

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
     * @inheritDoc
     */
    public function register(string $id, callable $invoker): self
    {
        $this->invokers[$id] = $invoker;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function registerSingleton(string $id, callable $invoker): self
    {
        $this->register($id, function () use ($invoker) {
            static $instance;

            if ($instance === null) {
                $instance = $invoker();
            }

            return $instance;
        });

        return $this;
    }
}