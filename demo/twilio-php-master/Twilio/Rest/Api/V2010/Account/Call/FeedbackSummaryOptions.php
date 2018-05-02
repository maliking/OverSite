<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\Options;
use Twilio\Values;

abstract class FeedbackSummaryOptions
{
    /**
     * @param boolean $includeSubaccounts The include_subaccounts
     * @param string $statusCallback The status_callback
     * @param string $statusCallbackMethod The status_callback_method
     * @return CreateFeedbackSummaryOptions Options builder
     */
    public static function create($includeSubaccounts = Values::NONE, $statusCallback = Values::NONE, $statusCallbackMethod = Values::NONE)
    {
        return new CreateFeedbackSummaryOptions($includeSubaccounts, $statusCallback, $statusCallbackMethod);
    }
}

class CreateFeedbackSummaryOptions extends Options
{
    /**
     * @param boolean $includeSubaccounts The include_subaccounts
     * @param string $statusCallback The status_callback
     * @param string $statusCallbackMethod The status_callback_method
     */
    public function __construct($includeSubaccounts = Values::NONE, $statusCallback = Values::NONE, $statusCallbackMethod = Values::NONE)
    {
        $this->options['includeSubaccounts'] = $includeSubaccounts;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
    }

    /**
     * The include_subaccounts
     *
     * @param boolean $includeSubaccounts The include_subaccounts
     * @return $this Fluent Builder
     */
    public function setIncludeSubaccounts($includeSubaccounts)
    {
        $this->options['includeSubaccounts'] = $includeSubaccounts;
        return $this;
    }

    /**
     * The status_callback
     *
     * @param string $statusCallback The status_callback
     * @return $this Fluent Builder
     */
    public function setStatusCallback($statusCallback)
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    /**
     * The status_callback_method
     *
     * @param string $statusCallbackMethod The status_callback_method
     * @return $this Fluent Builder
     */
    public function setStatusCallbackMethod($statusCallbackMethod)
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString()
    {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Api.V2010.CreateFeedbackSummaryOptions ' . implode(' ', $options) . ']';
    }
}