<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 28.02.17
 * Time: 17:07
 */

namespace Entities;



trait EntityTrait
{

    /**
     * @param $data
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function populateFromData($data){
        if(is_string($data)){

            $obj = json_decode($data);

            //if it is null, maybe the string is not uft8 encoded
            if($obj===null){
                $obj = json_decode(utf8_encode($data));
            }

            if($obj === null){
                throw new \InvalidArgumentException("the parameter \$data has to be a proper json, so a valid json in utf8 encoded, or an array or a class.");
            }

        }elseif(is_array($data) || is_object($data)){
            $obj = $data;
        }else{
            throw new \InvalidArgumentException("the parameter \$data has to be a proper json, so a valid json in utf8 encoded or an array or a class.");
        }


        foreach ($obj as $key => $value){
            if(property_exists($this,$key)){
                $this->{$key}=$value;
            }
        }

        return $this;



    }
}