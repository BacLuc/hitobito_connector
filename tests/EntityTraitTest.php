<?php

/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 28.02.17
 * Time: 17:38
 */

use PHPUnit\Framework\TestCase;
use HitobitoConnector\Mocks\EntityTraitMock;
use Entities\EntityTrait;

class EntityTraitTest extends TestCase
{

    public function testWithStdClass(){
        $class = new \stdClass();
        $class->testproperty = "test";
        $class->notExistingProperty = "test";

        $this->compareData($class, "test");

    }

    public function testWithArray(){
        $data = array();
        $data['testproperty'] = "test";
        $data['notExistingProperty'] = "test";

        $this->compareData($data, "test");

    }

    public function testWithJson(){
        $data = array();
        $data['testproperty'] = "test";
        $data['notExistingProperty'] = "test";

        $data = json_encode($data);

        $this->compareData($data, "test");

    }

    public function testWithInvalidData(){
        $data = 2;
        $this->expectException(\InvalidArgumentException::class);
        $this->compareData($data, "test");

    }

    public function testWithNotUTF8(){
        $data = array();
        $data['testproperty'] = "testü";
        $data['notExistingProperty'] = "test";

        $data = json_encode($data);
        $data = utf8_decode($data);
        $this->compareData($data, "testü");

    }

    public function testWithInvalidJsonAndNotUTF8(){
        $data = array();
        $data['testproperty'] = "testü";
        $data['notExistingProperty'] = "test";

        $data = json_encode($data);
        $data = utf8_decode($data);
        $data = substr($data,0, strlen($data)-2);
        $this->expectException(\InvalidArgumentException::class);
        $this->compareData($data, "testü");

    }



    /**
     * @param $class
     */
    private function compareData($data,$value)
    {
        $testMock = new EntityTraitMock();
        $testMock->populateFromData($data);

        $this->assertEquals($value, $testMock->getTestproperty());
        $this->expectException(PHPUnit_Framework_Error_Notice::class);
        $testMock->notExistingProperty;
    }
}