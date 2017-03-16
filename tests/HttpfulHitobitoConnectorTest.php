<?php

namespace HitobitoConnector\Test;

use HitobitoConnector\Exception\HitobitoConnectorException;
use HitobitoConnector\Exception\HttpException;
use HitobitoConnector\HttpfulHitobitoConnector;
use HitobitoConnector\HttpfulRequestConnector;
use Httpful\Request;
use PHPUnit\Framework\TestCase;
use HitobitoConnector\Test\Mocks\RequestMock;

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
        $lastAction = $lastActions[count($lastActions)-2];

        $this->assertArrayHasKey("method", $lastAction, "sendAuth not Implemented");


        $expectedurl = "$testurl/users/sign_in.json?person[email]=$testemail&person[password]=$testpassword";


        $this->assertEquals( "post",$lastAction['method']);
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);


        //now test if the answer is handled correctly

        $this->assertGreaterThan(0,strlen($object->getToken()));

        //check if authenticated person is set:
        $responseStdClass = json_decode(RequestMock::SIGNIN_ANSWER_SUCCESS);

        $authPerson = $responseStdClass->people[0];

        $this->assertJsonStringEqualsJsonString(json_encode($authPerson), json_encode($object->getAuthenticatedPerson()));

        //check if linked Groups is set
        $linkedGroups = $responseStdClass->linked->groups;
        $this->assertJsonStringEqualsJsonString(json_encode($linkedGroups), json_encode($object->getLinkedGroups()));



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
        $this->assertNull($object->getAuthenticatedPerson());
        $this->assertNull($object->getLinkedGroups());
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
        $lastAction = $lastActions[count($lastActions)-2];

        $this->assertArrayHasKey("method", $lastAction, "regenerateToken not Implemented");


        $expectedurl = "$testurl/users/token.json?person[email]=$testemail&person[password]=$testpassword";

        $this->assertEquals( "post",$lastAction['method']);
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
        $tokenBefore = $object->getToken();
        $authPersonBefore = $object->getAuthenticatedPerson();
        $linkedGroupsBefore = $object->getLinkedGroups();

        $request->setNextAnswer(RequestMock::REGENERATE_TOKEN_ANSWER_FAILURE);
        $this->expectException(HttpException::class);
        $object->regenerateToken();

        $this->assertEquals($tokenBefore,$object->getToken(), "if the regenartion fails, the token should not change");
        $this->assertEquals($authPersonBefore,$object->getAuthenticatedPerson());
        $this->assertEquals($linkedGroupsBefore, $object->getLinkedGroups());
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
        $methodResponse = $object->deleteToken();

        $this->assertEquals($object,$methodResponse,"the object was not returned by deleteToken");

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[count($lastActions)-2];

        $this->assertArrayHasKey("method", $lastAction, "deleteToken not Implemented");


        $expectedurl = "$testurl/users/token.json?person[email]=$testemail&person[password]=$testpassword";


        $this->assertEquals( "delete",$lastAction['method']);
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);


        //now test if the answer is handled correctly

        $this->assertNull($object->getToken(), "after deleting the token, the token in the class should be null");
        $this->assertNull($object->getAuthenticatedPerson());
        $this->assertNull($object->getLinkedGroups());
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
        $authPersonBefore = $object->getAuthenticatedPerson();
        $linkedGroupsBefore = $object->getLinkedGroups();

        $request->setNextAnswer(RequestMock::DELETE_TOKEN_ANSWER_FAILURE);
        $this->expectException(HttpException::class);
        $object->deleteToken();
        $this->assertEquals($tokenBefore,$object->getToken(), "if the regenartion fails, the token should not change");
        $this->assertEquals($authPersonBefore,$object->getAuthenticatedPerson());
        $this->assertEquals($linkedGroupsBefore, $object->getLinkedGroups());
    }

    public function testGetGroupsNotLoggedIn(){
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::REGENERATE_TOKEN_ANSWER_FAILURE);
        $this->expectException(HitobitoConnectorException::class);
        $object->getGroups();
    }

    public function testGetGroupsSuccess(){
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_SUCCESS);
        $object->sendAuth();
        $request->setNextAnswer(RequestMock::GET_GROUPS_ANSWER_SUCCESS);



        $response = $object->getGroups();

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[count($lastActions)-2];
        $expectedurl = "$testurl/groups.json?user_email=$testemail&user_token=".$object->getToken();

        $this->assertEquals( "get",$lastAction['method']);
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);



        $this->assertJsonStringEqualsJsonString(RequestMock::GET_GROUPS_ANSWER_SUCCESS, json_encode($response));
    }



    public function testGetGroupDetailSuccess(){
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $groupid = 2;
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_SUCCESS);
        $object->sendAuth();
        $request->setNextAnswer(RequestMock::GET_GROUPS_ANSWER_SUCCESS);



        $response = $object->getGroupDetails($groupid);

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[count($lastActions)-2];
        $expectedurl = "$testurl/groups/$groupid.json?user_email=$testemail&user_token=".$object->getToken();

        $this->assertEquals( "get",$lastAction['method']);
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);



        $this->assertJsonStringEqualsJsonString(RequestMock::GET_GROUP_2_PBS_DETAIL_ANSWER_SUCCESS, json_encode($response));
    }

    public function testPeopleOfGroupSuccess(){
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $groupid = 1416;
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_SUCCESS);
        $object->sendAuth();
        $request->setNextAnswer(RequestMock::GET_GROUP_1416_PEOPLE);



        $response = $object->getPeopleOfGroup($groupid);

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[count($lastActions)-2];
        $expectedurl = "$testurl/groups/$groupid/people.json?user_email=$testemail&user_token=".$object->getToken();

        $this->assertEquals( "get",$lastAction['method']);
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);



        $this->assertJsonStringEqualsJsonString(RequestMock::GET_GROUP_1416_PEOPLE, json_encode($response));
    }

    public function testPersonDetailSuccess(){
        $request = RequestMock::getInstance();
        $testurl = "http://test.com";
        $testemail = "test@email.com";
        $testpassword = "mypassword";
        $groupid = 1416;
        $peopleid = 9026;
        $object = new HttpfulHitobitoConnector($testurl,$testemail,$testpassword, $request);
        $request->setNextAnswer(RequestMock::SIGNIN_ANSWER_SUCCESS);
        $object->sendAuth();
        $request->setNextAnswer(RequestMock::GET_GROUP_1416_PEOPLE_XYZ);



        $response = $object->getPersonDetails($groupid, $peopleid);

        $lastActions = $request->getLastActions();
        $lastAction = $lastActions[count($lastActions)-2];
        $expectedurl = "$testurl/groups/$groupid/people/$peopleid.json?user_email=$testemail&user_token=".$object->getToken();

        $this->assertEquals( "get",$lastAction['method']);
        $this->assertEquals($expectedurl, $lastAction['parameters'][0]);



        $this->assertJsonStringEqualsJsonString(RequestMock::GET_GROUP_1416_PEOPLE_XYZ, json_encode($response));
    }


}