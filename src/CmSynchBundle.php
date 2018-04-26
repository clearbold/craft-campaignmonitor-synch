<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-synch
 * @copyright Copyright (c) Clearbold, LLC
 */

namespace clearbold\cmsynch;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Synch your Craft members or "people" entries with your Campaign Monitor subscriber lists.
 *
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 0.1.0
 */
class CmSynchBundle extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@clearbold/cmsynch/resources';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        // $this->js = [
        //     'script.js',
        // ];

        $this->css = [
            'styles.css',
        ];

        parent::init();
    }
}
