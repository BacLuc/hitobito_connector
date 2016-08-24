<?php

namespace HitobitoConnector\Test;

use HitobitoConnector\HttpfulHitobitoConnector;
use PHPUnit\Framework\TestCase;

class HttpfulHitobitoConnectorTest extends TestCase{
    function testLoad(){
        $object = new HttpfulHitobitoConnector();
        $this->assertEquals("HitobitoConnector\\HttpfulHitobitoConnector", get_class($object));
    }
}