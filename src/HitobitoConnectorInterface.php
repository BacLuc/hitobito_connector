<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 18:13
 */

namespace HitobitoConnector;


use HitobitoConnector\Entities\Group;
use HitobitoConnector\Entities\Person;

interface HitobitoConnectorInterface
{

    const test = 'test';

//    /**
//     * RestClientInterface constructor.
//     * @param string $url
//     * @param string $username
//     * @param string $password
//     * @param string $authurl
//     * @param
//     */
//    public function __construct($url, $username,$password,$authurl = "/users/sign_in.json", $restclient);

    /**
     * Sends the Auth Request and saves the token in a member and returns it
     * @return string token
     */
    public function sendAuth();

    /**
     * Sends the request to regenerate a token and saves the token in a member and returns it
     * @return string token
     */
    public function regenerateToken();

    public function deleteToken();


    /**
     * @return \stdClass of the json response
     */
    public function getGroups();


    /**
     * @param int $id
     * @return \stdClass of the json response
     */
    public function getGroupDetails($id);


    /**
     * @param $id
     * @return  \stdClass of the json response
     */
    public function getPeopleOfGroup($id);


    /**
     * @param $groupid
     * @param $personid
     * @return  \stdClass of the json response
     */
    public function getPersonDetails($groupid, $personid);


    /**
     * @return Person
     */
    public function getAuthenticatedPerson();


    /**
     * @return Group[]
     */
    public function getLinkedGroups();

    /**
     * @return array
     */
    public  function getLinks();

}