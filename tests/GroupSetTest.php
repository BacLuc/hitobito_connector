<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 16.03.17
 * Time: 11:10
 */
namespace HitobitoConnector\Test;


use HitobitoConnector\Entities\Person;
use Sets\GroupSet;
use PHPUnit\Framework\TestCase;


class GroupSetTest extends TestCase
{
    public function testAddElement(){
        //first test if  invalidargumentException is thrown
        $groupset = new GroupSet();
        $person = new Person();

        $this->expectException(\InvalidArgumentException::class);
        $groupset->addElement($person);



    }

}
