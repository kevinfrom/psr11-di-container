<?php

namespace Kevinfrom\DIContainer\Tests;

use PHPUnit\Framework\TestCase;
use stdClass;

abstract class LibraryTestCase extends TestCase
{
    protected function getTestObject(): stdClass
    {
        $object = new stdClass();
        $object->name = 'Lorem Ipsum';

        return $object;
    }
}