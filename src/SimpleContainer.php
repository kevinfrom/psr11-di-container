<?php

namespace Kevinfrom\DIContainer;

use Kevinfrom\DIContainer\Exception\NotFoundExtention;
use Psr\Container\ContainerInterface;

class SimpleContainer implements ContainerInterface
{
    /* @var array<class-string, callable> */
    private array $services = [];

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->has($id) === false) {
            throw new NotFoundExtention();
        }

        return call_user_func($this->services[$id]);
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    /**
     * Register a service to the container
     *
     * @param class-string $id
     * @param callback     $param
     *
     * @return void
     */
    public function register(string $id, callable $param): void
    {
        $this->services[$id] = $param;
    }
}