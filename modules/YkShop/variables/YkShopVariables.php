<?php
namespace modules\YkShop\variables;

class YkShopVariables {
	public function addToCart($product_id, $quantity){
		return \modules\YkShop\YkShop::$instance->ykshop->addToCart($product_id, $quantity);
	}
}