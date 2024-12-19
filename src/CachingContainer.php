<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

final class CachingContainer implements ContainerInterface
{
    /* @var array<class-string, object> $invokedServices */
    private array $invokedServices = [];

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

        if (isset($this->invokedServices[$id])) {
            return $this->invokedServices[$id];
        }

        $this->invokedServices[$id] = call_user_func($this->invokers[$id]);

        return $this->invokedServices[$id];
    }
    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->invokedServices[$id]) || isset($this->invokers[$id]);
    }

    /**
     * Register a service
     *
     * @param string   $id
     * @param callable $invoker
     *
     * @return $this
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
        $this->register($id, function () use ($id, $invoker) {
            if (isset($this->invokedServices[$id]) === false) {
                $this->invokedServices[$id] = call_user_func($invoker);
            }

            return $this->invokedServices[$id];
        });

        return $this;
    }

    /**
     * Clear invoked services cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        $this->invokedServices = [];
    }

    /**
     * Get the number of cached services
     *
     * @return int
     */
    public function cacheCount(): int
    {
        return count($this->invokedServices);
    }
}
