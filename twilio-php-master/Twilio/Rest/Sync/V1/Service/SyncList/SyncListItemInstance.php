<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property integer index
 * @property string accountSid
 * @property string serviceSid
 * @property string listSid
 * @property string url
 * @property string revision
 * @property array data
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string createdBy
 */
class SyncListItemInstance extends InstanceResource
{
    /**
     * Initialize the SyncListItemInstance
     *
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $serviceSid The service_sid
     * @param string $listSid The list_sid
     * @param integer $index The index
     * @return \Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemInstance
     */
    public function __construct(Version $version, array $payload, $serviceSid, $listSid, $index = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = array(
            'index' => Values::array_get($payload, 'index'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'listSid' => Values::array_get($payload, 'list_sid'),
            'url' => Values::array_get($payload, 'url'),
            'revision' => Values::array_get($payload, 'revision'),
            'data' => Values::array_get($payload, 'data'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'createdBy' => Values::array_get($payload, 'created_by'),
        );

        $this->solution = array(
            'serviceSid' => $serviceSid,
            'listSid' => $listSid,
            'index' => $index ?: $this->properties['index'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return \Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemContext Context
     *                                                                   for this
     *                                                                   SyncListItemInstance
     */
    protected function proxy()
    {
        if (!$this->context) {
            $this->context = new SyncListItemContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['listSid'],
                $this->solution['index']
            );
        }

        return $this->context;
    }

    /**
     * Fetch a SyncListItemInstance
     *
     * @return SyncListItemInstance Fetched SyncListItemInstance
     */
    public function fetch()
    {
        return $this->proxy()->fetch();
    }

    /**
     * Deletes the SyncListItemInstance
     *
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete()
    {
        return $this->proxy()->delete();
    }

    /**
     * Update the SyncListItemInstance
     *
     * @param array $data The data
     * @return SyncListItemInstance Updated SyncListItemInstance
     */
    public function update($data)
    {
        return $this->proxy()->update(
            $data
        );
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString()
    {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Sync.V1.SyncListItemInstance ' . implode(' ', $context) . ']';
    }
}