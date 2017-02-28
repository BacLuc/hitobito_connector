<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 28.02.17
 * Time: 16:36
 */

namespace Entities;


class BaseEntity implements \JsonSerializable
{
    /**
     * @codeCoverageIgnore
     * @return object
     */
    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}