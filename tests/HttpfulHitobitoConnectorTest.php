<?php

namespace HitobitoConnector;

use Exception\HttpException;
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

    function testAuthSuccess(){
        /**
         * @var RequestMock $request
         */
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);


        //test success
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_SUCCESS);
        $methodResponse = $object->sendAuth();

        $this->assertEquals($object,$methodResponse,"the object was not returned by sendAuth");

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[0];

        $this->assertArrayHasKey("method", $lastAction, "sendAuth not Implemented");


        $expectedurl = "$testurl/users/sign_in.json?person[email]=$testemail&person[password]=$testpassword";

        $this->assertEquals($lastAction['method'], "post");
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);


        //now test if the answer is handled correctly

        $this->assertGreaterThan(0,strlen($object->getToken()));






    }

    /**
     * @param $request
     * @param $object
     */
    public function testAuthFailure()
    {
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_FAILURE);
        $this->expectException(HttpException::class);
        $object->sendAuth();
    }


}