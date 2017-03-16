<?php

namespace HitobitoConnector;
use HitobitoConnector\Entities\Group;
use HitobitoConnector\Entities\Person;
use HitobitoConnector\Sets\GroupSet;
use HitobitoConnector\Sets\PeopleSet;


/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 14.03.17
 * Time: 10:15
 */
class ResultSet implements ResultSetInterface
{
    /**
     * @var  GroupSet
     */
    protected $groupset;

    /**
     * @var PeopleSet
     */
    protected $peopleset;

    public function __construct()
    {
        $this->groupset = new GroupSet();
        $this->peopleset = new PeopleSet();
    }

    /**
     * @return GroupSet
     */
    public function getGroupsSet()
    {
        return $this->groupset;
    }

    /**
     * @param GroupSet $groups
     * @return ResultSet
     */
    public function setGroupSet(GroupSet $groups)
    {
        $this->groupset = $groups;
        return $this;
    }

    /**
     * @return PeopleSet
     */
    public function getPeopleset()
    {
        return $this->peopleset;
    }

    /**
     * @param PeopleSet $peopleset
     * @return ResultSet
     */
    public function setPeopleset(PeopleSet $peopleset)
    {
        $this->peopleset = $peopleset;
        return $this;
    }

    public function addGroup(Group $group)
    {
        $this->groupset->addElement($group);
    }

    public function addPerson(Person $person)
    {
       $this->peopleset->addElement($person);
    }


}