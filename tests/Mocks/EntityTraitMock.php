<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 28.02.17
 * Time: 17:36
 */

namespace HitobitoConnector\Mocks;


use Entities\BaseEntity;
use Entities\EntityTrait;

class EntityTraitMock extends BaseEntity
{
    use EntityTrait;

    private $testproperty;

    /**
     * @return mixed
     */
    public function getTestproperty()
    {
        return $this->testproperty;
    }

    /**
     * @param mixed $testproperty
     */
    public function setTestproperty($testproperty)
    {
        $this->testproperty = $testproperty;
        return $this;
    }

}