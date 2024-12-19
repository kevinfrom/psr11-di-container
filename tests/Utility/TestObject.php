<?php

namespace Kevinfrom\DIContainer\Tests\Utility;

use stdClass;

trait TestObject
{
    protected function getTestObject(): stdClass
    {
        $object = new stdClass();
        $object->name = 'Lorem Ipsum';

        return $object;
    }
}