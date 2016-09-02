<?php

namespace HitobitoConnector;

use HitobitoConnector\HttpfulHitobitoConnector;
use HitobitoConnector\HttpfulRequestConnector;
use HitobitoConnector\Mocks\RequestMock;
use Httpful\Request;
use PHPUnit\Framework\TestCase;

class HttpfulHitobitoConnectorTest extends TestCase{
    function testLoad(){
        $object = new HttpfulHitobitoConnector(null,null,null,HttpfulRequestConnector::get(null));
        $this->assertEquals("HitobitoConnector\\HttpfulHitobitoConnector", get_class($object));
    }

    function testConstruct(){
        $request = HttpfulRequestConnector::post(null);
        $testurl = "testurl";
        $testemail = "testemail";
        $testpassword = "testpassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword,$request);
        $this->assertEquals($request, $object->getHttpfulinstance());
        $this->assertEquals($testurl, $object->getBaseurl());
        $this->assertEquals( $testemail,$object->getUseremail());
        $this->assertEquals($testpassword, $object->getUserpassword());

    }

    function testAuth(){
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $object->sendAuth();

        $lastAction = $request->getLastAction();
        $this->assertArrayHasKey("name", $lastAction, "sendAuth not Implemented");


        $expectedurl = "$testurl/users/sign_in.json?person[email]=$testemail&person[password]=$testpassword";

        $this->assertEquals($lastAction['name'], "post");
        $this->assertEquals($expectedurl, $lastAction['parameters']['url']);




    }




}