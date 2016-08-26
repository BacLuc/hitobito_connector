<?php

namespace HitobitoConnector\Test;

use HitobitoConnector\HttpfulHitobitoConnector;
use Httpful\Request;
use PHPUnit\Framework\TestCase;

class HttpfulHitobitoConnectorTest extends TestCase{
    function testLoad(){
        $object = new HttpfulHitobitoConnector(null,null,null,Request::get(null));
        $this->assertEquals("HitobitoConnector\\HttpfulHitobitoConnector", get_class($object));
    }

    function testConstruct(){
        $request = Request::post(null);
        $testurl = "testurl";
        $testemail = "testemail";
        $testpassword = "testpassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword,$request);
        $this->assertEquals($request, $object->getHttpfulinstance());
        $this->assertEquals($testurl, $object->getBaseurl());
        $this->assertEquals( $testemail,$object->getUseremail());
        $this->assertEquals($testpassword, $object->getUserpassword());

    }


}