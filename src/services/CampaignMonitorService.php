<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-lsynchists
 * @copyright Copyright (c) Clearbold, LLC
 *
 * Synch your Craft members or "people" entries with your Campaign Monitor subscriber lists.
 *
 */

namespace clearbold\cmsynch\services;

require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_subscribers.php';

use clearbold\cmsynch\CmSynch;

use Craft;
use craft\base\Component;

/**
 * @author    Mark Reeves
 * @since     0.1.0
 */
class CampaignMonitorService extends Component
{
    /**
     * @var settings
     * @todo declare it once
     */

    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function importSubscribers($listId = '', $subscribers = array())
    {
        $settings = CmSynch::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);
            $result = $client->import($subscribers, false);

            if($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }
}