<?php
namespace YouKnowww\YkShop\migrations;

use Craft;
use craft\db\Migration;
use craft\models\Section;
use craft\models\Fields;

class Install extends Migration{
	public function safeUp(): bool {
		// create channel for products
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
		
		// Create the field group
		$groupModel = new FieldGroupModel();
		$groupModel->name = 'YkShopProducts';
		craft()->fields->saveGroup($groupModel);
		
		// I haven't yet found a way to get the group ID without looping through all of the groups. saveGroup() returns a boolean and doesn't appear to update the id attribute of the original model instance.
		$groups = craft()->fields->getAllGroups();
		
		foreach($groups as $group) {
			if($group->name != 'YkShopProducts') {
				continue;
			}
			
			$groupModel = $group;
		}
		
		// Create the tab
		$tabModel = new FieldLayoutTabModel();
		// Get the desired layout (in this case, the User layout) and use the tab's setLayout to link the two
		$layout = craft()->fields->getLayoutByType(ElementType::Entry);
		$tabModel->setLayout($layout);
		$tabModel->name = 'YkShopProducts';
		
		// Create the fields. I have a protected class member that contains the fields in a 'fieldName' => 'FieldName' format.
		
		// Name field
		$name_field = new FieldModel();
		$name_field->groupId = $groupModel->id;
		$name_field->name = Craft::t('Display Name');
		$name_field->handle = 'yk_shop_product_display_name';
		$name_field->translatable = false;
		$name_field->type = 'PlainText';
		
		// Description field
		$description_field = new FieldModel();
		$description_field->groupId = $groupModel->id;
		$description_field->name = Craft::t('Description');
		$description_field->handle = 'yk_shop_product_description';
		$description_field->translatable = false;
		$description_field->type = 'PlainText';
		
		// quantity field
		$images_field = new FieldModel();
		$images_field->groupId = $groupModel->id;
		$images_field->name = Craft::t('Images');
		$images_field->handle = 'yk_shop_product_images';
		$images_field->translatable = false;
		$images_field->type = 'Assets';
		
		$price_field = new FieldModel();
		$price_field->groupId = $groupModel->id;
		$price_field->name = Craft::t('Price');
		$price_field->handle = 'yk_shop_product_price';
		$price_field->translatable = false;
		$price_field->type = 'Number';
		
		// quantity field
		$stock_field = new FieldModel();
		$stock_field->groupId = $groupModel->id;
		$stock_field->name = Craft::t('Stock');
		$stock_field->handle = 'yk_shop_product_stock';
		$stock_field->translatable = false;
		$stock_field->type = 'Number';

		craft()->fields->saveField($price_field);
		craft()->fields->saveField($stock_field);
		
		// Get all of the group's fields. This could also be done by saving an array of the fields in the loop above, but this seems a bit cleaner to me, and since we already have the group object, saves us an object/variable declaration.
		$fields = $groupModel->getFields();
		
		// Set the tab's fields. This gives us a custom grouping in the layout editor.
		$tabModel->setFields($fields);
		
		// Get the existing tabs (and, by extension, fields), since we don't want to nuke the layout, just add to it. I couldn't find any sort of "addTab" type function, so this is how we have to do it.
		$layoutTabs = $layout->getTabs();
		
		// getTabs() returns an array, so simply add our new tab to the array.
		$layoutTabs[] = $tabModel;
		
		// Now, set the tabs back in the layout.
		$layout->setTabs($layoutTabs);
		
		// done approve
		return true;
	}
	
	/*
	public function safeDown(): bool{
	}
	*/
}
