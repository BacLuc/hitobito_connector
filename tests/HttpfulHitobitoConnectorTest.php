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
        /**
         * @var RequestMock $request
         */
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_FAILURE);
        $this->expectException(HttpException::class);
        $object->sendAuth();
        $this->assertNull($object->getToken(), "if authentification failes, no token should be set.");
    }

    public function testRegenerateTokenSuccess()
    {
        /**
         * @var RequestMock $request
         */
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);


        //test success
        $request->setNextAnswer(RequestMock::REGENERATE_TOKEN_ANSWER_SUCCESS);
        $methodResponse = $object->regenerateToken();

        $this->assertEquals($object,$methodResponse,"the object was not returned by regenerateToken");

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[0];

        $this->assertArrayHasKey("method", $lastAction, "regenerateToken not Implemented");


        $expectedurl = "$testurl/users/token.json?person[email]=$testemail&person[password]=$testpassword";

        $this->assertEquals($lastAction['method'], "post");
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);


        //now test if the answer is handled correctly

        $this->assertGreaterThan(0,strlen($object->getToken()));
    }


    public function testRegenerateTokenFailure()
    {
        /**
         * @var RequestMock $request
         */
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $tokenBefore = $object->getToken();
        $request->setNextAnswer(RequestMock::REGENERATE_TOKEN_ANSWER_FAILURE);
        $this->expectException(HttpException::class);
        $object->regenerateToken();
        $this->assertEquals($tokenBefore,$object->getToken(), "if the regenartion fails, the token should not change");
    }


    public function testDeleteTokenSuccess()
    {
        /**
         * @var RequestMock $request
         */
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);


        //test success
        $request->setNextAnswer(RequestMock::DELETE_TOKEN_ANSWER_SUCCESS);
        $methodResponse = $object->regenerateToken();

        $this->assertEquals($object,$methodResponse,"the object was not returned by deleteToken");

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[0];

        $this->assertArrayHasKey("method", $lastAction, "deleteToken not Implemented");


        $expectedurl = "$testurl/users/token.json?person[email]=$testemail&person[password]=$testpassword";

        $this->assertEquals($lastAction['method'], "delete");
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);


        //now test if the answer is handled correctly

        $this->assertNull(strlen($object->getToken()), "after deleting the token, the token in the class should be null");
    }


    public function testDeleteTokenFailure()
    {
        /**
         * @var RequestMock $request
         */
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $tokenBefore = $object->getToken();
        $request->setNextAnswer(RequestMock::DELETE_TOKEN_ANSWER_FAILURE);
        $this->expectException(HttpException::class);
        $object->deleteToken();
        $this->assertEquals($tokenBefore,$object->getToken(), "if the regenartion fails, the token should not change");
    }




}