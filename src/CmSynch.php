<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-lists
 * @copyright Copyright (c) Clearbold, LLC
 */

namespace clearbold\cmsynch;

use clearbold\cmsynch\services\CampaignMonitorService;
use clearbold\cmsynch\variables\CmSynchVariable;
use clearbold\cmsynch\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use yii\base\Event;

/**
 * View and manage your Campaign Monitor subscriber lists in your Craft CMS control panel.
 *
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 0.1.0
 */
class CmSynch extends Plugin
{
    public $hasCpSection = true;
    public static $plugin;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            // 'campaignmonitor' => \clearbold\cmsynch\services\CampaignMonitorService::class,
        ]);

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                // $event->rules['cm-synch/<>'] = ['template' => 'cm-synch/...'];
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('cmSynch', CmSynchVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'cm-synch',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    protected function createSettingsModel()
    {
        return new \clearbold\cmsynch\models\Settings();
    }

    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('cm-synch/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}
