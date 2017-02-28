<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 18:20
 */

namespace HitobitoConnector;


use Exception\HttpException;
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


    public function __construct($baseurl, $useremail, $password, RequestInterface $httpfulinstance)
    {
        $this->baseurl = $baseurl;
        $this->useremail = $useremail;
        $this->userpassword = $password;
        $this->httpfulinstance = $httpfulinstance;
    }

    private function sendRequestWithAuth($method = 'get', $path){
        $url = $this->baseurl;
        if($url[strlen($url)-1] != "/"){
            $url .= "/";
        }
        $url .= "$path?person[email]=".$this->useremail."&person[password]=".$this->userpassword;

        //call the request tool static, because it is static defined
        $classname = get_class($this->httpfulinstance);
        /**
         *
         */
        $request = null;
        switch ($method){
            case "post":
                $request = $classname::post($url);
                break;
            case "put":
                $request = $classname::put($url);
                break;
            case "delete":
                $request = $classname::delete($url);
                break;
            case "head":
                $request = $classname::head($url);
                break;
            case "options":
                $request = $classname::options($url);
                break;
            case "patch":
                $request = $classname::patch($url);
                break;

            default:
                $request = $classname::get($url);
                break;

        }
        return $request->send();
    }

    /**
     * Sends the Auth Request and saves the token in a member and returns it
     * @return string token
     */
    public function sendAuth()
    {
        $response = $this->sendRequestWithAuth("post", "users/sign_in.json");
        if($response->code == 200){
            $this->token = $response->body->people[0]->authentication_token;
        }else{
            throw new HttpException("Authentification failed.");
        }
        return $this;

    }

    /**
     * Sends the request to regenerate a token and saves the token in a member and returns it
     * @return string token
     */
    public function regenerateToken()
    {
        $response = $this->sendRequestWithAuth("post", "users/token.json");
        if($response->code == 200){
            $this->token = $response->body->people[0]->authentication_token;
        }else{
            throw new HttpException("Authentification failed.");
        }
        return $this;
    }

    public function deleteToken(){
        $response = $this->sendRequestWithAuth("delete", "users/token.json");
        if($response->code == 200){
            $this->token = null;
        }else{
            throw new HttpException("Authentification failed.");
        }
        return $this;
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
    public function getUseremail()
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
    public function getUserpassword()
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
    public function getToken()
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
    public function getBaseurl()
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
    public function getHttpfulinstance()
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