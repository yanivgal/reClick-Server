<?php

namespace reClick\GCM;

class Message {

    private $data;
    private $registrationIds;
    private $collapseKey;
    private $timeToLive;
    private $delayWhileIdle;
    private $restrictedPackageName;
    private $dryRun;

    /**
     * Constructor
     *
     * @param array $data
     * @param array $registrationIds
     * @param string $collapseKey
     * @param int $timeToLive
     * @param bool $delayWhileIdle
     * @param string $restrictedPackageName
     * @param bool $dryRun
     */
    public function __construct(
        array $data = null,
        array $registrationIds = null,
        $collapseKey = null,
        $timeToLive = null,
        $delayWhileIdle = false,
        $restrictedPackageName = null,
        $dryRun = false
    ) {
        $this->data = $data;
        $this->registrationIds = $registrationIds;
        $this->collapseKey = $collapseKey;
        $this->timeToLive = $timeToLive;
        $this->delayWhileIdle = $delayWhileIdle;
        $this->restrictedPackageName = $restrictedPackageName;
        $this->dryRun = $dryRun;
    }

    /**
     * Gets/Sets the data property
     *
     * @param array|null $data
     * @return array|Message
     */
    public function data($data = null) {
        return $this->getterSetter('data', $data);
    }

    /**
     * Adds a key/value pair to the payload data.
     *
     * @param string $key
     * @param string $value
     * @return Message
     */
    public function addData($key, $value) {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Gets data property as json string
     *
     * @return string
     */
    public function dataJson() {
        return json_encode($this->data);
    }

    /**
     * Gets/Sets the registrationIds property.
     *
     * @param array|null $registrationIds
     * @return array|Message
     */
    public function registrationIds($registrationIds = null) {
        return $this->getterSetter('registrationIds', $registrationIds);
    }

    /**
     * Adds a registration id.
     *
     * @param int $registrationId
     * @return Message
     */
    public function addRegistrationId($registrationId) {
        $this->registrationIds[] = $registrationId;

        return $this;
    }

    /**
     * Gets registrationIds property as json string
     *
     * @return string
     */
    public function registrationIdJson() {
        return json_encode($this->registrationIds);
    }

    /**
     * Gets/Sets the collapseKey property.
     *
     * @param string|null $collapseKey
     * @return string|Message
     */
    public function collapseKey($collapseKey = null) {
        return $this->getterSetter('collapseKey', $collapseKey);
    }

    /**
     * Gets/Sets the time to live, in seconds.
     *
     * @param int|null $timeToLive
     * @return int|Message
     */
    public function timeToLive($timeToLive = null) {
        return $this->getterSetter('timeToLive', $timeToLive);
    }

    /**
     * Gets/Sets the delayWhileIdle property (default value is false).
     *
     * @param bool $delayWhileIdle
     * @return bool|Message
     */
    public function delayWhileIdle($delayWhileIdle = null) {
        return $this->getterSetter('delayWhileIdle', $delayWhileIdle);
    }

    /**
     * Gets/Sets the restrictedPackageName property.
     *
     * @param string|null $restrictedPackageName
     * @return string|Message
     */
    public function restrictedPackageName($restrictedPackageName = null) {
        return $this->getterSetter(
            'restrictedPackageName',
            $restrictedPackageName
        );
    }

    /**
     * Gets/Sets the dryRun property (default value is false).
     *
     * @param boolean|null $dryRun
     * @return boolean|Message
     */
    public function dryRun($dryRun = null) {
        return $this->getterSetter('dryRun', $dryRun);
    }

    public function toJson() {
        if (!isset($this->data) || !isset($this->registrationIds)) {
            return null;
        }

        $message = [];

        if (isset($this->collapseKey)) {
            $message['collapse_key'] = $this->collapseKey;
        }
        if (isset($this->timeToLive)) {
            $message['time_to_live'] = $this->timeToLive;
        }

        $message['delay_while_idle'] = $this->delayWhileIdle;
        $message['dryRun'] = $this->dryRun;
        $message['data'] = $this->data;
        $message['registration_ids'] = $this->registrationIds;

        return json_encode($message);
    }

    public function __toString() {
        return $this->toJson();
    }

    /**
     * Generic simple getter/setter
     *
     * @param string $property
     * @param string $value
     * @return Message|mixed
     */
    private function getterSetter($property, $value = null) {
        if (property_exists($this, $property)) {
            if (!isset($value)) {
                return $this->$property;
            }

            $this->$property = $value;
        }

        return $this;
    }
}
