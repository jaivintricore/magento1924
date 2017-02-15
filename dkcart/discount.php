<?php
	include_once('config.php');
	session_start();
	define('MAGENTO', realpath(dirname(__FILE__)."/.."));
	require_once MAGENTO.'/app/Mage.php';
	umask(0);
	Mage::init();	
	if (isset($_POST['code'])) {
		$coupon_code = $_POST['code'];
		$today = date("Y-d-m");
		$Coupon = Mage::getModel('salesrule/coupon')->load($coupon_code, 'code');
		$rule = Mage::getModel('salesrule/rule')->load($Coupon->getRuleId());
		$cart_products = $_SESSION['cart'];
		if($rule->getData('is_active') && ($rule->getData('to_date') >=$today || $rule->getData('to_date') == '')){
			$response['status'] = true;
			foreach($cart_products as $cart_product){
				$productId = $cart_product['id'];
				$qty = $cart_product['qty'];
				$price = $cart_product['price'];
				/*if($cart_product['special_price'] > 0){
					$price = $cart_product['special_price'];
				}
				if($cart_product['rule_price'] > 0){
					$price = $cart_product['rule_price'];
				}*/
				$product_model= Mage::getModel('catalog/product')->load($productId);

				$originalPrice = '';
				$cost = '';
				$originalPrice = $cart_product['price'];
				$cost = $product_model->getCost();
				
				$productArray['price'] = $price;
				$productArray['original_price'] = $originalPrice;
				$productArray['cost'] = $cost;				
				$productArray['qty'] = $qty;						
				
				$ruleArray['rule_id'] = $rule->getData('rule_id');
				$ruleArray['discount_amount'] = $rule->getDiscountAmount();
				$ruleArray['discount_step'] = $rule->getDiscountStep();
				$ruleArray['rule_percent'] = min(100, $rule->getDiscountAmount());
				$ruleArray['simple_action'] = $rule->getSimpleAction();

				$quoteObj = new Mage_Sales_Model_Quote();			

				$quoteItem = Mage::getModel('sales/quote_item')->setProduct($product_model);
				$quoteItem->setQuote($quoteObj);
				$quoteItem->setAllItems(array($product_model));
				$quoteItem->getProduct()->setProductId($product_model->getEntityId());
				$quoteItem->setQty($qty);						
				if($rule->getConditions()->validate($quoteItem) && $rule->getActions()->validate($quoteItem)){
					$discountProductAmount = getDiscountAmount($productArray,$ruleArray);
					$totalDiscountAmount += $discountProductAmount;
				}
			}
		}
		$currency_symbol =  $_COOKIE['currency_symbol'];
		$formatedPrice = "-".$currency_symbol.number_format((float)$totalDiscountAmount, 2, '.', '');
		$response['discount'] = $formatedPrice;
		$_SESSION['discount_amount'] = $totalDiscountAmount;
		echo json_encode($response);
	}
	function getDiscountAmount($productArray,$ruleArray)
	{
		$qty = $productArray['qty'];
		$price = $productArray['price'];
		$originalPrice = $productArray['original_price'];
		$cost = $productArray['cost'];
		
		$rule_id = $ruleArray['rule_id'];
		$ruleDiscountAmount = $ruleArray['discount_amount'];
		$ruleDiscountStep = $ruleArray['discount_step'];
		$rulePercent = $ruleArray['rule_percent'];
		$simple_action = $ruleArray['simple_action'];
		
		
		switch ($simple_action){
			case 'by_percent':
				if ($ruleDiscountStep) {
					$qty = floor($qty/$ruleDiscountStep)*$ruleDiscountStep;
				}						
				$discountAmount = ($qty * $price) * $rulePercent/100;
			break;
			case 'by_fixed':						
				if ($ruleDiscountStep) {
					$qty = floor($qty/$ruleDiscountStep)*$ruleDiscountStep;
				}											
				$quoteAmount        = Mage::app()->getStore()->convertPrice($ruleDiscountAmount);
				$discountAmount     = $qty * $quoteAmount;
			break;
			case 'by_original':
				if ($ruleDiscountStep) {
					$qty = floor($qty/$ruleDiscountStep)*$ruleDiscountStep;
				}
				$origpricediscount = (($originalPrice) * ($ruleDiscountAmount))/100;
				$originalpricewithdiscount = $originalPrice - $origpricediscount;
				if($price > $originalpricewithdiscount){					
					$gapprice = $qty*($originalPrice - $price);
					$origpricediscounttotal = ($qty*$originalPrice) * $ruleDiscountAmount/100;
					$discountAmount = $origpricediscounttotal - $gapprice;
				}
			break;
			case 'at_cost':
				if ($ruleDiscountStep) {
					$qty = floor($qty/$ruleDiscountStep)*$ruleDiscountStep;
				}
				if($price > $cost){
					$gapprice = $qty*($price - $cost);
					$discountAmount = $gapprice;
				}
			break;
			default:
				$discountAmount = 0;
			break;
		}
		return $discountAmount;
	}
