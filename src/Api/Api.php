<?php

namespace seregazhuk\Favro\Api;

use seregazhuk\Favro\Api\Endpoints\Cards;
use seregazhuk\Favro\Api\Endpoints\Tasks;
use seregazhuk\Favro\Api\Endpoints\Users;
use seregazhuk\Favro\Api\Endpoints\Columns;
use seregazhuk\Favro\Api\Endpoints\Widgets;
use seregazhuk\Favro\Api\Endpoints\Endpoint;
use seregazhuk\Favro\Api\Endpoints\Collections;
use seregazhuk\Favro\Api\Endpoints\Organizations;
use seregazhuk\Favro\Api\Endpoints\EndpointsContainer;

/**
 * Class Api
 *
 * @property Organizations $organizations
 * @property Users $users
 * @property Collections $collections
 * @property Widgets $widgets
 * @property Columns $columns
 * @property Cards $cards
 * @property Tasks $tasks
 */
class Api
{
    /**
     * @var EndpointsContainer
     */
    protected $endpointsContainer;

    /**
     * @var string
     */
    protected $organizationId;

    public function __construct(EndpointsContainer $endpointsContainer)
    {
        $this->endpointsContainer = $endpointsContainer;
    }

    /**
     * Magic method to access different endpoints.
     *
     * @param string $endpoint
     *
     * @return Endpoint
     */
    public function __get($endpoint)
    {
        $endpoint = $this->endpointsContainer->resolve($endpoint);

        if (method_exists($endpoint, 'setOrganizationId')) {
            $endpoint->setOrganizationId($this->organizationId);
        }

        return $endpoint;
    }

    /**
     * @param string $organization
     * @return $this
     */
    public function setOrganization($organization)
    {
        $organizations = $this->organizations->getAll();
        foreach ($organizations['entities'] as $entity) {
            if($entity['name'] == $organization) {
                $this->organizationId = $entity['organizationId'];
            }
        }

        return $this;
    }

    /**
     * @param int $organizationId
     * @return $this
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;

        return $this;
    }


    /**
     * @return string
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }
}