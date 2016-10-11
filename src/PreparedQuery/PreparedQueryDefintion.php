<?php namespace DCarbone\PHPConsulAPI\PreparedQuery;

/*
   Copyright 2016 Daniel Carbone (daniel.p.carbone@gmail.com)

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

use DCarbone\PHPConsulAPI\AbstractModel;

/**
 * Class PreparedQueryDefinition
 * @package DCarbone\PHPConsulAPI\PreparedQuery
 */
class PreparedQueryDefinition extends AbstractModel
{
    /** @var string */
    public $ID = '';
    /** @var string */
    public $Name = '';
    /** @var string */
    public $Session = '';
    /** @var string */
    public $Token = '';
    /** @var ServiceQuery|null */
    public $Service = null;
    /** @var QueryDNSOptions|null */
    public $DNS = null;
    /** @var QueryTemplate|null */
    public $Template = null;

    /**
     * PreparedQueryDefinition constructor.
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->Service = new ServiceQuery();
        $this->DNS = new QueryDNSOptions();
        $this->Template = new QueryTemplate();
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param string $ID
     * @return PreparedQueryDefinition
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     * @return PreparedQueryDefinition
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->Session;
    }

    /**
     * @param string $Session
     * @return PreparedQueryDefinition
     */
    public function setSession($Session)
    {
        $this->Session = $Session;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @param string $Token
     * @return PreparedQueryDefinition
     */
    public function setToken($Token)
    {
        $this->Token = $Token;
        return $this;
    }

    /**
     * @return ServiceQuery|null
     */
    public function getService()
    {
        return $this->Service;
    }

    /**
     * @param ServiceQuery $Service
     * @return PreparedQueryDefinition
     */
    public function setService(ServiceQuery $Service)
    {
        $this->Service = $Service;
        return $this;
    }

    /**
     * @return QueryDNSOptions|null
     */
    public function getDNS()
    {
        return $this->DNS;
    }

    /**
     * @param QueryDNSOptions $DNS
     * @return PreparedQueryDefinition
     */
    public function setDNS(QueryDNSOptions $DNS)
    {
        $this->DNS = $DNS;
        return $this;
    }

    /**
     * @return QueryTemplate|null
     */
    public function getTemplate()
    {
        return $this->Template;
    }

    /**
     * @param QueryTemplate $Template
     * @return PreparedQueryDefinition
     */
    public function setTemplate(QueryTemplate $Template)
    {
        $this->Template = $Template;
        return $this;
    }
}