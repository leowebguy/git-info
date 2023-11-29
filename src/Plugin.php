<?php
/**
 * Output git info over twig
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2023, leowebguy
 * @license    MIT
 */

namespace leowebguy\gitinfo;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\web\twig\variables\CraftVariable;
use leowebguy\gitinfo\variables\GitVariable;
use yii\base\Event;

class Plugin extends BasePlugin
{
    public bool $hasCpSection = false;

    public bool $hasCpSettings = false;

    public function init(): void
    {
        parent::init();

        if (!$this->isInstalled) {
            return;
        }

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $event->sender->set('git', GitVariable::class);
            }
        );

        Craft::info(
            'Git Info plugin loaded',
            __METHOD__
        );
    }
}
