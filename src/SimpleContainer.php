<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Exception\NotFoundExtention;
use Psr\Container\ContainerInterface;

class SimpleContainer implements ContainerInterface
{
    /* @var array<class-string, callable> $invokers */
    private array $invokers = [];

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->has($id) === false) {
            throw new NotFoundExtention();
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
     * Register a service to the container
     *
     * @param class-string $id
     * @param callback     $invoker
     *
     * @return void
     */
    public function register(string $id, callable $invoker): void
    {
        $this->invokers[$id] = $invoker;
    }

    public function registerSingleton(string $id, callable $invoker): void
    {
        $this->invokers[$id] = function () use ($invoker) {
            static $instance;

            if ($instance === null) {
                $instance = $invoker();
            }

            return $instance;
        };
    }
}