<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-synch
 * @copyright Copyright (c) Clearbold, LLC
 *
 * Synch your Craft members or "people" entries with your Campaign Monitor subscriber lists.
 *
 */

namespace clearbold\cmsynch\models;

use clearbold\cmsynch\CmSynch;

use Craft;
use craft\base\Model;

/**
 * @author    Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since     0.1.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $apiKey = null;
    /**
     * @var string
     */
    public $clientId = null;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiKey'], 'string'],
            [['apiKey'], 'required'],
            [['clientId'], 'string'],
            [['clientId'], 'required'],
        ];
    }
}