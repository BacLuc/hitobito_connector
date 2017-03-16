<?php
/**
 * Created by PhpStorm.
 * User: lucius
 * Date: 24.08.16
 * Time: 19:34
 */

namespace HitobitoConnector;


class RetrieveDataJob
{
    /**
     * @var HitobitoConnectorInterface
     */
    protected $connector;
    /**
     * @var ResultSetInterface
     */
    protected $resultset;
    public function __construct(HitobitoConnectorInterface $connector, ResultSetInterface $resultset)
    {
        $this->connector = $connector;
        $this->resultset = $resultset;
    }

    public function retrieveData(){

        //log in add logged in person to resultset
        $this->connector->sendAuth();

        $loggedInPerson = $this->connector->getAuthenticatedPerson();

        $this->resultset->addPerson($loggedInPerson);



    }



}