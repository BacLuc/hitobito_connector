<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 01.09.16
 * Time: 22:59
 */

namespace HitobitoConnector\Mocks;


use HitobitoConnector\Request;
use HitobitoConnector\RequestInterface;
use HitobitoConnector\Response;

trait MockTrait
{


    /**
     * @var MockTrait
     */
    private static $instance = null;

    /**
     * @var array
     */
    private $lastActions = array();


    /**
     * @param MockTrait $instance
     * @return MockTrait
     */
    public static function setInstance(MockTrait $instance){
        static::$instance = $instance;
        return static::$instance;
    }

    /**
     * @return MockTrait
     */
    public static function getInstance(){
        if(static::$instance == null){
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * MockTrait constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getLastAction(){
        if(count($this->lastActions)==0){
            return array();
        }
        return $this->lastActions[count($this->lastActions)-1];
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this|mixed
     */
    public function __call($name, $arguments)
    {
        if($name == "__construct"){
            return static::getInstance();
        }
        $this->lastActions[] = array("method" => $name, "parameters" => $arguments);
        if(method_exists($this,$name)){
            return call_user_func(array($this, $name), $arguments);
        }
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this|mixed
     */
    public static function __callStatic($name, $arguments)
    {

        if(method_exists(static::class,$name)){
            return call_user_func(array(static::class, $name), $arguments);
        }
        return static::getInstance();
    }
    public function addLastAction($name,array $parameters){
        $this->lastActions[] = array("method" => $name, "parameters" => $parameters);
        return $this;
    }
}