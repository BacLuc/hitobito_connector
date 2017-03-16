<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 16.03.17
 * Time: 11:10
 */
namespace HitobitoConnector\Test;


use HitobitoConnector\Entities\Group;
use HitobitoConnector\Entities\Person;
use Sets\GroupSet;
use PHPUnit\Framework\TestCase;


class GroupSetTest extends TestCase
{
    public function testAddElementWrongType(){
        //last test if  invalidargumentException is thrown
        $groupset = new GroupSet();
        $person = new Person();

        $this->expectException(\InvalidArgumentException::class);
        $groupset->addElement($person);

    }

    public function testAddElementIdNull(){

        //test if element with id null can be added
        $groupset = new GroupSet();
        $group = new Group();
        $this->expectException(\InvalidArgumentException::class);
        $groupset->addElement($group);
    }

    public function testAddElement(){
        $groupset = new GroupSet();
        $group = new Group();

        $group->setId(1);
        //test if element added:
        $groupset->addElement($group);
        $this->assertSame($group,$groupset->getElement(1));
        $this->assertEquals(1,count($groupset->getElements()));

        //test that adding same element doesn't affect groupset
        $groupset->addElement($group);
        $this->assertSame($group,$groupset->getElement(1));
        $this->assertEquals(1,count($groupset->getElements()));

        //test adding element with same id does not affect groupset, and old element is kept
        $group2 = new Group();
        $group2->setId(1);
        $groupset->addElement($group2);
        $this->assertSame($group,$groupset->getElement(1));
        $this->assertNotSame($group2,$groupset->getElement(1));
        $this->assertEquals(1,count($groupset->getElements()));

        //test adding element with another id adds the element as expected
        $group3 = new Group();
        $group3->setId(2);
        $groupset->addElement($group3);
        $this->assertSame($group3,$groupset->getElement(2));
        $this->assertEquals(2,count($groupset->getElements()));

        //test getMatchingElement
        $groupSimilarAs1 = new Group();
        $groupSimilarAs1->setId(1);
        $this->assertSame($group,$groupset->getMatchingElement($groupSimilarAs1));



    }

    public function testIdExists(){
        $groupset = new GroupSet();

        //test on empty set
        $this->assertFalse($groupset->idExists(1));

        //test on not empty set, but wrong id
        $group = new Group();
        $group->setId(1);
        $groupset->addElement($group);
        $this->assertFalse($groupset->idExists(2));

        //test if found
        $this->assertTrue($groupset->idExists(1));

    }

    public function checkElementExists(){
            $groupset = new GroupSet();
            $groupNotIn = new Group();
            $groupNotIn->setId(2);

            //test on empty set
            $this->assertFalse($groupset->elementExists($groupNotIn));

            //test on not empty set, but wrong id
            $group = new Group();
            $group->setId(1);
            $groupset->addElement($group);
            $this->assertFalse($groupset->elementExists($groupNotIn));

            //test if found
            $this->assertTrue($groupset->elementExists($group));


    }

    public function testGetElement(){
            $groupset = new GroupSet();

            //test on empty set
            $this->assertNull($groupset->getElement(1));

            //test on not empty set, but wrong id
            $group = new Group();
            $group->setId(1);
            $groupset->addElement($group);
            $this->assertNull($groupset->getElement(2));

            //test if found
            $this->assertSame($group,$groupset->getElement(1));


    }

}
