<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 16.03.17
 * Time: 14:17
 */

namespace HitobitoConnector;


use HitobitoConnector\Entities\Group;
use HitobitoConnector\Entities\Person;

interface ResultSetInterface
{
    public function addGroup(Group $group);

    public function addPerson(Person $person);


}