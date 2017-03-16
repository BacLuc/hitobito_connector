<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 16.03.17
 * Time: 10:45
 */

namespace Sets;


use Entities\BaseEntity;

abstract class BaseEntitySet
{

    const ENTITY_TYPE = "HitobitoConnector\\Entities\\BaseEntity";

    const INVALIDARGUMENTEXCEPTION = '$element has class %s, but this Set works with %s, so invalid Entity Type';

    /**
     * @var BaseEntity[]
     */
    protected $elements = array();

    public function __construct()
    {

    }

    /**
     * @param BaseEntity $element
     * @return $this
     */
    public function addElement(BaseEntity $element){
        $this->checkType($element);
        $this->checkIdNotNull($element);


        if(!$this->elementExists($element)){
            $this->elements[$element->getId()]=$element;
        }
        return $this;
    }



    /**
     * @param BaseEntity $element
     * @return bool
     */
    public function elementExists(BaseEntity $element){
        $this->checkType($element);
        $this->checkIdNotNull($element);
        return array_key_exists($element->getId(),$this->elements);
    }

    /**
 * @return BaseEntity[]
 */
    public function getElements()
    {
        return $this->elements;
    }

    public function getElement(int $id){
        if(!$this->idExists($id)){
            return null;
        }
        return $this->elements[$id];

    }

    public function getMatchingElement(BaseEntity $element){
        $this->checkType($element);
        $this->checkIdNotNull($element);
        return $this->getElement($element->getId());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function idExists(int $id){
        return array_key_exists($id,$this->elements);
    }

    /**
     * @param BaseEntity $entity
     * @return bool
     */
    private function typeMatches(BaseEntity $entity){
        return static::ENTITY_TYPE == get_class($entity);
    }

    /**
     * @param BaseEntity $element
     */
    private function checkType(BaseEntity $element)
    {
        if (!$this->typeMatches($element)) {
            throw new \InvalidArgumentException(sprintf(static::INVALIDARGUMENTEXCEPTION, get_class($element), static::ENTITY_TYPE));
        }
        return true;
    }

    private function checkIdNotNull(BaseEntity $element){
        if(strlen($element->getId()) == 0){
            throw new \InvalidArgumentException("The id of the element must not be null");
        }
        return true;
    }

}