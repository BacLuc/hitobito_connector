<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 19:31
 */

namespace HitobitoConnector\Entities;


use Entities\BaseEntity;
use Entities\EntityTrait;

class Person extends BaseEntity
{
    use EntityTrait;
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $company_name;

    /**
     * @var bool
     */
    private $company;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $authentication_token;

    /**
     * @var \DateTime
     */
    private $last_sign_in_at;

    /**
     * @var \DateTime
     */
    private $current_sign_in_at;

    /**
     * @var array
     */
    private $links;

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @codeCoverageIgnore
     * @param string $id
     * @return Person
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @codeCoverageIgnore
     * @param string $type
     * @return Person
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @codeCoverageIgnore
     * @param string $href
     * @return Person
     */
    public function setHref(string $href)
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @codeCoverageIgnore
     * @param string $first_name
     * @return Person
     */
    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @codeCoverageIgnore
     * @param string $last_name
     * @return Person
     */
    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @codeCoverageIgnore
     * @param string $nickname
     * @return Person
     */
    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @codeCoverageIgnore
     * @param string $company_name
     * @return Person
     */
    public function setCompanyName(string $company_name)
    {
        $this->company_name = $company_name;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return bool
     */
    public function isCompany(): bool
    {
        return $this->company;
    }

    /**
     * @codeCoverageIgnore
     * @param bool $company
     * @return Person
     */
    public function setCompany(bool $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @codeCoverageIgnore
     * @param string $gender
     * @return Person
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @codeCoverageIgnore
     * @param string $email
     * @return Person
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getAuthenticationToken()
    {
        return $this->authentication_token;
    }

    /**
     * @codeCoverageIgnore
     * @param string $authentication_token
     * @return Person
     */
    public function setAuthenticationToken(string $authentication_token)
    {
        $this->authentication_token = $authentication_token;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return \DateTime
     */
    public function getLastSignInAt()
    {
        return $this->last_sign_in_at;
    }

    /**
     * @codeCoverageIgnore
     * @param \DateTime $last_sign_in_at
     * @return Person
     */
    public function setLastSignInAt(\DateTime $last_sign_in_at)
    {
        $this->last_sign_in_at = $last_sign_in_at;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return \DateTime
     */
    public function getCurrentSignInAt()
    {
        return $this->current_sign_in_at;
    }

    /**
     * @codeCoverageIgnore
     * @param \DateTime $current_sign_in_at
     * @return Person
     */
    public function setCurrentSignInAt(\DateTime $current_sign_in_at)
    {
        $this->current_sign_in_at = $current_sign_in_at;
        return $this;
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
     * @param array $links
     * @return Person
     */
    public function setLinks(array $links)
    {
        $this->links = $links;
        return $this;
    }



}