<?php
namespace modules\YkShop;

use Craft;
use yii\base\Module;
use yii\base\Event;

use craft\web\View;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\twig\variables\CraftVariable;

use modules\YkShop\services\YkShopServices;
use modules\YkShop\variables\YkShopVariables;

class YkShop extends Module{
	/**
	 * @var Module Self-referential module property.
	 */
	public static $instance;

	public function init(){
		self::$instance = $this;
		Craft::setAlias('@ykshop', __DIR__);
		parent::init();

		$this->setComponents([ 'ykshop' => YkShop::class ]);

		Event::on(
			CraftVariable::class,
			CraftVariable::EVENT_INIT,
			function (Event $event) {
				$variable = $event->sender;
				$variable->set('ykShop', YkShopVariables::class);
			}
		);

		Event::on(
			View::class,
			View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
			function(RegisterTemplateRootsEvent $event) {
				$event->roots['ykShop'] = __DIR__ . '/templates';
			}
		);
	}
}
