<?php
include_once('config.php');

if (isset($_POST['id']) && isset($_POST['attribute80']) && isset($_POST['attribute125'])) {
    getChildProductValues($_POST['id'], $_POST['attribute80'], $_POST['attribute125']);
}
elseif (isset($_POST['id']) && isset($_POST['wl'])) { // add item to wishlist
    addItemToWishlist();
}
else { // get all totals info
    getTotalsInfo();
}

function getChildProductValues($productId, $attribute80, $attribute125)
{
    $conn = $_SESSION['conn'];
    $attributes = $simplePid = '';
    $qty = 1;
    $sql = "SELECT `link_table`.`product_id`, `at_color`.`value` AS `color`, `at_size`.`value` AS `size` FROM `mgn_catalog_product_entity` AS `e`
                                  INNER JOIN
                            `mgn_catalog_product_super_link` AS `link_table` ON link_table.product_id = e.entity_id
                                  INNER JOIN
                            `mgn_catalog_product_entity_int` AS `at_color` ON (`at_color`.`entity_id` = `e`.`entity_id`) AND (`at_color`.`attribute_id` = '80') AND (`at_color`.`store_id` = 0)
                                  INNER JOIN
                            `mgn_catalog_product_entity_int` AS `at_size` ON (`at_size`.`entity_id` = `e`.`entity_id`) AND (`at_size`.`attribute_id` = '125') AND (`at_size`.`store_id` = 0)
                        WHERE (link_table.parent_id = ".$productId.")
                            AND (at_color.value=".$attribute80.")
                            AND (at_size.value=".$attribute125.")";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $simplePid = $row['product_id'];
        $sql = "SELECT qty,stock_status FROM mgn_cataloginventory_stock_status WHERE product_id=".$row['product_id'];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $rowStock = $result->fetch_assoc();
            $qty = $rowStock['qty'];
        }
    }
    $sql = "SELECT value FROM mgn_eav_attribute_option_value WHERE option_id=".$attribute80;
    $resultColor = $conn->query($sql);
    if ($resultColor->num_rows > 0) {
        $row = $resultColor->fetch_assoc();
        $attributes = $row['value'];
    }
    $sql = "SELECT value FROM mgn_eav_attribute_option_value WHERE option_id=".$attribute125;
    $resultColor = $conn->query($sql);
    if ($resultColor->num_rows > 0) {
        $row = $resultColor->fetch_assoc();
        $attributes .= ', '.$row['value'];
    }
    echo json_encode(array ('qty' => $qty, 'attributes' => $attributes, 'pid' => $simplePid));
}

function addItemToWishlist()
{
    /*$wishlist = Mage::getModel('wishlist/wishlist')->loadByCustomer($customerId, true);
    $product = Mage::getModel('catalog/product')->load($productId);
    $buyRequest = new Varien_Object(array()); // any possible options that are configurable and you want to save with the product - e.g. product='99', qty='1', super_attribute[133]='3'
    $result = $wishlist->addNewItem($product, $buyRequest);
    $wishlist->save();*/
}

function getTotalsInfo()
{
    $totals = array ('subtotal' => 0, 'grandtotal' => 0);
    if(isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $i=>$item) {
            $price = 0;
            if (!empty($item['rule_price']))
                $price = $item['rule_price'];
            elseif (!empty($item['special_price']))
                $price = $item['special_price'];
            else
                $price = $item['price'];
            $totals['subtotal'] += ($price*$item['qty']);
        }
        $totals['grandtotal'] = $totals['subtotal'];
    }
    $_SESSION['cart_subtotal'] = $totals['subtotal'];
    if (isset($_SESSION['current_shipping_price']) && isset($_SESSION['cart']) && count($_SESSION['cart'])>0)
        $totals['grandtotal'] += $_SESSION['current_shipping_price'];
    //$totals['subtotal'] = Mage::helper('core')->currency($totals['subtotal'], true, false);
    echo json_encode($totals);
}