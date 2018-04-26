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

use clearbold\cmsynch\CmLists;

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
        $settings = CmLists::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);

            $result = $client->import($subscribers);

            if($result->was_successful()) {
                $body = array();
                // foreach ($result->response as $list) {
                //     $body[] = $list;
                // }
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response
                ];
            }
            /*
            if($result->was_successful()) {
                echo "Subscribed with results <pre>";
                var_dump($result->response);
            } else {
                echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
                var_dump($result->response);
                echo '</pre>';

                if($result->response->ResultData->TotalExistingSubscribers > 0) {
                    echo 'Updated '.$result->response->ResultData->TotalExistingSubscribers.' existing subscribers in the list';        
                } else if($result->response->ResultData->TotalNewSubscribers > 0) {
                    echo 'Added '.$result->response->ResultData->TotalNewSubscribers.' to the list';
                } else if(count($result->response->ResultData->DuplicateEmailsInSubmission) > 0) { 
                    echo $result->response->ResultData->DuplicateEmailsInSubmission.' were duplicated in the provided array.';
                }

                echo 'The following emails failed to import correctly.<pre>';
                var_dump($result->response->ResultData->FailureDetails);
            }
            */
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }
}