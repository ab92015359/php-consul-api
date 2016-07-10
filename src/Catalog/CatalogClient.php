<?php namespace DCarbone\PHPConsulAPI\Catalog;

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

use DCarbone\PHPConsulAPI\AbstractConsulClient;
use DCarbone\PHPConsulAPI\QueryMeta;
use DCarbone\PHPConsulAPI\QueryOptions;
use DCarbone\PHPConsulAPI\Request;
use DCarbone\PHPConsulAPI\WriteMeta;
use DCarbone\PHPConsulAPI\WriteOptions;

/**
 * Class CatalogClient
 * @package DCarbone\PHPConsulAPI\Catalog
 */
class CatalogClient extends AbstractConsulClient
{
    /**
     * @param CatalogRegistration $catalogRegistration
     * @param WriteOptions|null $writeOptions
     * @return array(
     *  @type WriteMeta write meta data
     *  @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function register(CatalogRegistration $catalogRegistration, WriteOptions $writeOptions = null)
    {
        $r = new Request('put', 'v1/catalog/register', $this->_Config, $catalogRegistration);
        $r->setWriteOptions($writeOptions);

        list($duration, $_, $err) = $this->requireOK($this->doRequest($r));
        $wm = $this->buildWriteMeta($duration);

        return [$wm, $err];
    }

    /**
     * @param CatalogDeregistration $catalogDeregistration
     * @param WriteOptions|null $writeOptions
     * @return array(
     *  @type WriteMeta write meta data
     *  @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function deregister(CatalogDeregistration $catalogDeregistration, WriteOptions $writeOptions = null)
    {
        $r = new Request('put', 'v1/catalog/deregister', $this->_Config, $catalogDeregistration);
        $r->setWriteOptions($writeOptions);

        list($duration, $_, $err) = $this->requireOK($this->doRequest($r));
        $wm = $this->buildWriteMeta($duration);

        return [$wm, $err];
    }

    /**
     * @return array(
     *  @type string[]|null list of datacenters or null on error
     *  @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function datacenters()
    {
        $r = new Request('get', 'v1/catalog/datacenters', $this->_Config);

        list($_, $response, $err) = $this->requireOK($this->doRequest($r));

        if (null !== $err)
            return [null, $err];

        return $this->decodeBody($response);
    }

    /**
     * @param QueryOptions|null $queryOptions
     * @return array(
     *  @type CatalogNode[]|null array of catalog nodes or null on error
     *  @type \DCarbone\PHPConsulAPI\QueryMeta query metadata
     *  @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function nodes(QueryOptions $queryOptions = null)
    {
        $r = new Request('get', 'v1/catalog/nodes', $this->_Config);
        $r->setQueryOptions($queryOptions);

        list($duration, $response, $err) = $this->requireOK($this->doRequest($r));
        $qm = $this->buildQueryMeta($duration, $response);

        if (null !== $err)
            return [null, $qm, $err];

        list($data, $err) = $this->decodeBody($response);

        if (null !== $err)
            return [null, $qm, $err];

        $nodes = array();
        foreach($data as $v)
        {
            $node = new CatalogNode($v);
            $nodes[$node->getNode()] = $node;
        }

        return [$nodes, $qm, null];
    }

    /**
     * @param QueryOptions|null $queryOptions
     * @return array(
     * @type string[]|null list of services or null on error
     * @type \DCarbone\PHPConsulAPI\QueryMeta query metadata
     * @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function services(QueryOptions $queryOptions = null)
    {
        $r = new Request('get', 'v1/catalog/services', $this->_Config);
        $r->setQueryOptions($queryOptions);

        list($duration, $response, $err) = $this->requireOK($this->doRequest($r));
        $qm = $this->buildQueryMeta($duration, $response);

        if (null !== $err)
            return [null, $qm, $err];

        list($data, $err) = $this->decodeBody($response);

        return [$data, $qm, $err];
    }

    /**
     * @param string $service
     * @param string $tag
     * @param QueryOptions|null $queryOptions
     * @return array(
     *  @type CatalogService[]|null array of services or null on error
     *  @type \DCarbone\PHPConsulAPI\QueryMeta query metadata
     *  @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function service($service, $tag = '', QueryOptions $queryOptions = null)
    {
        $r = new Request('get', sprintf('v1/catalog/service/%s', rawurlencode($service)), $this->_Config);
        $r->setQueryOptions($queryOptions);
        if ('' !== $tag)
            $r->params()->set('tag', $tag);

        list($duration, $response, $err) = $this->requireOK($this->doRequest($r));
        $qm = $this->buildQueryMeta($duration, $response);

        if (null !== $err)
            return [null, $qm, $err];
        
        list($data, $err) = $this->decodeBody($response);
        
        if (null !== $err)
            return [null, $qm, $err];
        
        $services = array();
        foreach($data as $v)
        {
            $service = new CatalogService($v);
            $services[$service->getServiceID()] = $service;
        }

        return [$services, $qm, null];
    }

    /**
     * @param string $node
     * @param QueryOptions|null $queryOptions
     * @return array(
     *  @type CatalogNode node or null on error
     *  @type \DCarbone\PHPConsulAPI\QueryMeta query metadata
     *  @type \DCarbone\PHPConsulAPI\Error|null error, if any
     * )
     */
    public function node($node, QueryOptions $queryOptions = null)
    {
        $r = new Request('get', sprintf('v1/catalog/node/%s', rawurlencode($node)), $this->_Config);
        $r->setQueryOptions($queryOptions);

        list($duration, $response, $err) = $this->requireOK($this->doRequest($r));
        $qm = $this->buildQueryMeta($duration, $response);

        if (null !== $err)
            return [null, $qm, $err];

        list($data, $err) = $this->decodeBody($response);

        if (null !== $err)
            return [null, $qm, $err];

        return [new CatalogNode($data), $qm, null];
    }
}