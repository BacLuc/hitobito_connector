<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 19:31
 */

namespace HitobitoConnector\Entities;


use Entities\BaseEntity;
use Entities\EntityTrait;

class Group extends BaseEntity
{
    use EntityTrait;

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $group_type;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Group
     */
    public function setId(string $id): Group
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Group
     */
    public function setName(string $name): Group
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupType(): string
    {
        return $this->group_type;
    }

    /**
     * @param string $group_type
     * @return Group
     */
    public function setGroupType(string $group_type): Group
    {
        $this->group_type = $group_type;
        return $this;
    }



}