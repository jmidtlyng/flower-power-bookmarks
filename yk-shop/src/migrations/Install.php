<?php
namespace YouKnowww\YkShop\migrations;

use Craft;
use craft\db\Migration;
use craft\models\Section;

class Install extends Migration{
		public function safeUp(): bool {
			// testing
			echo 'testing install script';
			
			if (is_null(Craft::$app->sections->getSectionByHandle("ykShopProducts"))) {
				$section = new Section([
											'name' => 'YK Shop Products',
											'handle' => 'ykShopProducts',
											'type' => Section::TYPE_CHANNEL,
											'siteSettings' => [
													new \craft\models\Section_SiteSettings([
															'siteId' => Craft::$app->sites->getPrimarySite()->id,
															'enabledByDefault' => true,
															'hasUrls' => true,
															'uriFormat' => 'yk-shop-product/{slug}',
															'template' => 'yk-shop-product/_entry']),
												]], true);
				
				Craft::$app->sections->saveSection($section);
			}
			// done approve
			return true;
		}
		
		/*
		public function safeDown(): bool{
		}
		*/
}
