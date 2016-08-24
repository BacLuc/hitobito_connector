<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 18:20
 */

namespace HitobitoConnector;


class HttpfulHitobitoConnector implements HitobitoConnectorInterface
{

    /**
     * Sends the Auth Request and saves the token in a member and returns it
     * @return string token
     */
    public function sendAuth()
    {
        // TODO: Implement sendAuth() method.
    }

    /**
     * Sends the request to regenerate a token and saves the token in a member and returns it
     * @return string token
     */
    public function regenerateToken()
    {
        // TODO: Implement regenerateToken() method.
    }

    /**
     * @return \stdClass of the json response
     */
    public function getGroups()
    {
        // TODO: Implement getGroups() method.
    }

    /**
     * @param int $id
     * @return \stdClass of the json response
     */
    public function getGroupDetails($id)
    {
        // TODO: Implement getGroupDetails() method.
    }

    /**
     * @param $id
     * @return  \stdClass of the json response
     */
    public function getPeopleOfGroup($id)
    {
        // TODO: Implement getPeopleOfGroup() method.
    }

    /**
     * @param $groupid
     * @param $personid
     * @return  \stdClass of the json response
     */
    public function getPersonDetails($groupid, $personid)
    {
        // TODO: Implement getPersonDetails() method.
    }
}