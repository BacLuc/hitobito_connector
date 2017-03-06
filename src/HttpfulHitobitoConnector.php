<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 18:20
 */

namespace HitobitoConnector;


use Exception\HitobitoConnectorException;
use Exception\HttpException;
use HitobitoConnector\Entities\Group;
use HitobitoConnector\Entities\Person;
use HitobitoConnector\Mocks\RequestMock;
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


    /**
     * @var Person
     */
    private $authenticatedPerson;

    /**
     * @var Group[]
     */
    private $linkedGroups;

    /**
     * @var array
     */
    private $links;


    public function __construct($baseurl, $useremail, $password, RequestInterface $httpfulinstance)
    {
        $this->baseurl = $baseurl;
        $this->useremail = $useremail;
        $this->userpassword = $password;
        $this->httpfulinstance = $httpfulinstance;
    }

    /**
     * @codeCoverageIgnore
     * @param string $method
     * @param $path
     * @return \Httpful\Response
     */
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
        /**
         * @var Request $request
         */
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

            //populate person
            $authPerson = $response->body->people[0];
            $person = new Person();
            $person->populateFromData($authPerson);
            $this->authenticatedPerson =$person;

            //populate groups
            $groups = $response->body->linked->groups;
            if(is_array($groups)){
                foreach($groups as $num => $value){
                    $group = new Group();
                    $group->populateFromData($value);
                    $this->linkedGroups[$num]=$value;
                }
            }

            //populate links
            $this->links = $response->body->links;

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
        $response = $this->sendRetrieveDataRequest("/groups");

        return $this->handleGetDataResponse($response);


    }

    /**
     * @param int $id
     * @return \stdClass of the json response
     */
    public function getGroupDetails($id)
    {
        $response = $this->sendRetrieveDataRequest("/groups/$id");

        return $this->handleGetDataResponse($response);
    }

    /**
     * @param $id
     * @return  \stdClass of the json response
     */
    public function getPeopleOfGroup($id)
    {
        $response = $this->sendRetrieveDataRequest("/groups/$id/people");

        return $this->handleGetDataResponse($response);
    }

    /**
     * @param $groupid
     * @param $personid
     * @return  \stdClass of the json response
     */
    public function getPersonDetails($groupid, $personid)
    {
        $response = $this->sendRetrieveDataRequest("/groups/$groupid/people/$personid");

        return $this->handleGetDataResponse($response);
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getUseremail()
    {
        return $this->useremail;
    }

    /**
     * @codeCoverageIgnore
     * @param string $useremail
     */
    public function setUseremail(string $useremail)
    {
        $this->useremail = $useremail;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getUserpassword()
    {
        return $this->userpassword;
    }

    /**
     * @codeCoverageIgnore
     * @param string $userpassword
     */
    public function setUserpassword(string $userpassword)
    {
        $this->userpassword = $userpassword;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @codeCoverageIgnore
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getBaseurl()
    {
        return $this->baseurl;
    }

    /**
     * @codeCoverageIgnore
     * @param string $baseurl
     */
    public function setBaseurl(string $baseurl)
    {
        $this->baseurl = $baseurl;
    }

    /**
     * @codeCoverageIgnore
     * @return Request
     */
    public function getHttpfulinstance()
    {
        return $this->httpfulinstance;
    }

    /**
     * @codeCoverageIgnore
     * @param Request $httpfulinstance
     */
    public function setHttpfulinstance(Request $httpfulinstance)
    {
        $this->httpfulinstance = $httpfulinstance;
    }

    /**
     * @codeCoverageIgnore
     * @return Person
     */
    public function getAuthenticatedPerson()
    {
        return $this->authenticatedPerson;
    }

    /**
     * @codeCoverageIgnore
     * @return Group[]
     */
    public function getLinkedGroups()
    {
        return $this->linkedGroups;
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @codeCoverageIgnore
     * @param $path string
     * @return mixed
     */
    private function sendRetrieveDataRequest($path)
    {
        $url = $this->getBaseurl() . $path.".json?user_email={$this->getUseremail()}&user_token=" . $this->getToken();
        $classname = get_class($this->httpfulinstance);
        $response = $classname::get($url)->send();
        return $response;
    }

    /**
     * @codeCoverageIgnore
     * @param $response
     * @return mixed
     * @throws HitobitoConnectorException
     * @throws HttpException
     */
    private function handleGetDataResponse($response)
    {
        if ($response->code == 200) {
            return $response->body;
        } else {
            if (property_exists($response->body, "error")) {
                $errorBody = json_decode(RequestMock::REGENERATE_TOKEN_ANSWER_FAILURE);
                if ($errorBody->error == $response->body->error) {
                    throw new HitobitoConnectorException("You have to sign in, before you start retrieving data");
                } else {
                    throw new HttpException($response->code);
                }
            }
        }
    }
}