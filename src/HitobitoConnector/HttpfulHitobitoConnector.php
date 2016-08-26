<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 18:20
 */

namespace HitobitoConnector;


use Httpful\Httpful;
use Httpful\Request;

class HttpfulHitobitoConnector implements HitobitoConnectorInterface
{

    /**
     * @var string
     */
    private $useremail;

    /**
     * @var string
     */
    private $userpassword;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $baseurl;

    /**
     * @var Request
     */
    private $httpfulinstance;


    public function __construct($baseurl, $useremail, $password, Request $httpfulinstance)
    {
        $this->baseurl = $baseurl;
        $this->useremail = $useremail;
        $this->userpassword = $password;
        $this->httpfulinstance = $httpfulinstance;
    }

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

    /**
     * @return string
     */
    public function getUseremail(): string
    {
        return $this->useremail;
    }

    /**
     * @param string $useremail
     */
    public function setUseremail(string $useremail)
    {
        $this->useremail = $useremail;
    }

    /**
     * @return string
     */
    public function getUserpassword(): string
    {
        return $this->userpassword;
    }

    /**
     * @param string $userpassword
     */
    public function setUserpassword(string $userpassword)
    {
        $this->userpassword = $userpassword;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getBaseurl(): string
    {
        return $this->baseurl;
    }

    /**
     * @param string $baseurl
     */
    public function setBaseurl(string $baseurl)
    {
        $this->baseurl = $baseurl;
    }

    /**
     * @return Request
     */
    public function getHttpfulinstance(): Request
    {
        return $this->httpfulinstance;
    }

    /**
     * @param Request $httpfulinstance
     */
    public function setHttpfulinstance(Request $httpfulinstance)
    {
        $this->httpfulinstance = $httpfulinstance;
    }
}