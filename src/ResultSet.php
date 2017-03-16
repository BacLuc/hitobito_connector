<?php

namespace HitobitoConnector;
use HitobitoConnector\Entities\Group;


/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 14.03.17
 * Time: 10:15
 */
class ResultSet
{
    /**
     * @var array
     * array of groupid => group
     */
    protected $groups = array();

    /**
     * @var array
     * array of peopleid => Person
     */
    protected $people = array();

    public function __construct()
    {
    }

    public function addGroup(Group $group)
    {
        if(!array_key_exists($group->getId(), $this->groups)){
            $this->groups[$group->getId()]=$group;
        }

    }


}