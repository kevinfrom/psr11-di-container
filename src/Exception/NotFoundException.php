<?php

namespace Kevinfrom\DIContainer\Exception;

use Psr\Container\NotFoundExceptionInterface;
use Exception;

final class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}