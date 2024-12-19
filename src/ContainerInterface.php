<?php

namespace Kevinfrom\DIContainer;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    /**
     * Register a service
     *
     * @param string   $id
     * @param callable $invoker
     *
     * @return self
     */
    public function register(string $id, callable $invoker): self;

    /**
     * Register a singleton service
     *
     * @param string   $id
     * @param callable $invoker
     *
     * @return self
     */
    public function registerSingleton(string $id, callable $invoker): self;
}