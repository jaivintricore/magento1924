<?php
//include_once('config.php');
include_once('shipping.php');

//setcookie("dkcart", "", time(), "/"); unset($_COOKIE['dkcart']);  unset($_SESSION['cart']);
//echo '<pre>' . print_r($_SESSION, true) . '</pre>';
//print_r($_SESSION['cart']);
 //print_r($_POST);exit;
$conn = $_SESSION['conn'];
$cookie = isset($_COOKIE['dkcart']) ? $_COOKIE['dkcart'] : ""; //print_r($cookie);
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
$productId = isset($_POST['product']) ? $_POST['product'] : "";
$cartUpdate = (empty($action) && empty($productId)) ? false : true;

try {
    // get base URL for product's image
    $imageUrl = isset($_SESSION['base_image_url']) ? $_SESSION['base_image_url'] : "";

    // get attribute options, product type, and simple productID for configurable product
    $attributeValue80 = $attributeValue125 = "";
    $superAttribute80 = (isset($_POST["super_attribute_80"]) && !empty($_POST["super_attribute_80"])) ? $_POST["super_attribute_80"] : 0; // color
    $superAttribute125 = (isset($_POST["super_attribute_125"]) && !empty($_POST["super_attribute_125"])) ? $_POST["super_attribute_125"] : 0; // size
    $giftcard = '';
    if (isset($_POST['giftcard_amount']) && isset($_POST['giftcard_recipient_email']) && $_POST['giftcard_recipient_name '] && $_POST['giftcard_sender_name']) {
        $giftcard = '{"giftcard_amount":'.$_POST['giftcard_amount'].',"giftcard_recipient_name":'.$_POST['giftcard_recipient_name '].',"giftcard_recipient_email":'.$_POST['giftcard_recipient_email'].',"giftcard_message":'.$_POST['giftcard_message'].',"giftcard_sender_name":'.$_POST['giftcard_sender_name'].'}';
    }
    $productType = "";
    $childProductId = 0;
    if ($cartUpdate) {
        if (empty($productId) && isset($_GET['id']))
            $productId = $_GET['id'];
        $sql = "SELECT type_id FROM mgn_catalog_product_entity WHERE entity_id=".$productId;
        $resultType = $conn->query($sql);
        if ($resultType->num_rows > 0) {
            $row = $resultType->fetch_assoc();
            $productType = $row['type_id']; // getting product type
        }
        if ($productType == "configurable" && (!empty($superAttribute80) || !empty($superAttribute125))) {
            $sql = "SELECT `link_table`.`product_id`, `at_color`.`value` AS `color`, `at_size`.`value` AS `size` FROM `mgn_catalog_product_entity` AS `e`
                                  INNER JOIN
                            `mgn_catalog_product_super_link` AS `link_table` ON link_table.product_id = e.entity_id
                                  INNER JOIN
                            `mgn_catalog_product_entity_int` AS `at_color` ON (`at_color`.`entity_id` = `e`.`entity_id`) AND (`at_color`.`attribute_id` = '80') AND (`at_color`.`store_id` = 0)
                                  INNER JOIN
                            `mgn_catalog_product_entity_int` AS `at_size` ON (`at_size`.`entity_id` = `e`.`entity_id`) AND (`at_size`.`attribute_id` = '125') AND (`at_size`.`store_id` = 0)
                        WHERE (link_table.parent_id = ".$productId.")";
            if (!empty($superAttribute80)) {
                $sql .= " AND (at_color.value=".$superAttribute80.")";
            }
            if (!empty($superAttribute125)) {
                $sql .= " AND (at_size.value=".$superAttribute125.")";
            } //echo $sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $childProductId = $row['product_id']; //print_r($row);
                if (empty($superAttribute80))
                    $superAttribute80 = $row['color'];
                if (!empty($superAttribute125))
                    $superAttribute125 = $row['size'];
            }
        }
    }
    if ($superAttribute80) {
        $sql = "SELECT value FROM mgn_eav_attribute_option_value WHERE option_id=".$superAttribute80;
        $resultColor = $conn->query($sql);
        if ($resultColor->num_rows > 0) {
            $row = $resultColor->fetch_assoc();
            $attributeValue80 = $row['value'];
        }
    }
    if ($superAttribute125) {
        $sql = "SELECT value FROM mgn_eav_attribute_option_value WHERE option_id=".$superAttribute125;
        $resultColor = $conn->query($sql);
        if ($resultColor->num_rows > 0) {
            $row = $resultColor->fetch_assoc();
            $attributeValue125 = $row['value'];
        }
    }

    // get customer id
    $customerId = Mage::helper('customer')->getCustomer()->getId();
    /*if (isset($_COOKIE['dkcart_customerid']) && !empty($_COOKIE['dkcart_customerid'])) {
        $customerId = base64_decode($_COOKIE['dkcart_customerid']);
    }*/ //echo "Customer ID: ".$customerId;

    //print_r($_SESSION['cart']);exit;
    // prepare cart items data (set session data from cookie/database, or insert session data into database for logged-in customer)
    $cartId = prepareCartData($customerId, $cartUpdate, $cookie, $imageUrl, $conn);


    if($action=="update") {  /***** update cart *****/
        if(!empty($_SESSION['cart'])){
            updateCartItem($customerId, $cartId, $conn);
        }
    } elseif($action=="delete") { /***** delete item from cart *****/
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        deleteCartItem($id, $customerId, $cartId, $conn);
    } elseif (isset($_POST['product'])) {  /***** add item to cart *****/
        $qty = isset($_POST['qty']) ? $_POST['qty'] : 1;
        $addItem = true;
        $pid = (!empty($childProductId)) ? $childProductId : $productId;
        if(!empty($_SESSION['cart'])){
            if (!empty($customerId)) {
                if (!empty($giftcard)) { // for giftcard product
                    $sql = "SELECT item_id FROM mgn_dkcart_items WHERE product_id=".$productId." AND cart_id=".$cartId." AND giftcard='".$giftcard."'";
                } elseif (!empty($childProductId)) { // for configurable product
                    $sql = "SELECT item_id FROM mgn_dkcart_items WHERE product_id=".$productId." AND cart_id=".$cartId." AND child_product_id=".$childProductId;
                } else { // for simple product
                    $sql = "SELECT item_id FROM mgn_dkcart_items WHERE product_id=".$productId." AND cart_id=".$cartId;
                }
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                }
            }
            foreach ($_SESSION['cart'] as $i=>$item) {
                if ($item['id'] == $productId && $item['giftcard'] == $giftcard && $item['child_product_id'] == $childProductId) {
                    $qty = (int)$item['qty'] + $qty;
                    $sql = "SELECT qty,stock_status FROM mgn_cataloginventory_stock_status WHERE product_id=".$pid;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $rowStock = $result->fetch_assoc();
                        if ($rowStock['stock_status'] == 1) {
                            if ($qty > $rowStock['qty']) {
                                $qty = $rowStock['qty'];
                                echo "Item is not available in requested quantity";
                            }
                            $item['qty'] = $qty;
                            $_SESSION['cart'][$i] = $item;
                            if (!empty($customerId)) {
                                $sql = "UPDATE mgn_dkcart_items SET qty=".$item['qty']." WHERE item_id=".$row['item_id'];
                                $conn->query($sql);
                            }
                        }
                    }
                    $addItem = false;
                }
            }
        }
        if ($addItem) { // add item
            addCartItem($customerId, $productId, $cartId, $qty, $attributeValue80, $attributeValue125, $superAttribute80, $superAttribute125, $imageUrl, $childProductId, $giftcard, $conn);
        }
    }

    // delete cart - when there is no item into cart
    if (!isset($_SESSION['cart']) || count($_SESSION['cart'])<1) {
        deleteCart($customerId, $cartUpdate, $conn);
    }

    // set cookie when customer not logged-in
    if (empty($customerId) && isset($_SESSION['cart'])) {
        setCartCookie();
    }

    //include_once('cart.phtml');
} catch (Exception $e) {

}
//$conn->close();



/*** function - get product's special price ***/
function getSpecialPrice($productId, $conn)
{
    $sprice = "";
    $sql = "SELECT value FROM mgn_catalog_product_entity_decimal WHERE entity_id=" . $productId . " AND attribute_id = " . $_SESSION['attribute_id_special_price'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sprice = $row["value"];
    }
    if (!empty($sprice)) {
        $isSpecial = false;
        $sql = "SELECT value FROM mgn_catalog_product_entity_datetime where attribute_id=(SELECT attribute_id FROM mgn_eav_attribute WHERE entity_type_id=4 AND ea.attribute_code='special_from_date')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fromDate = $row["value"];
            if (!empty($fromDate)) {
                $fromDate = date("Y-m-d", strtotime($fromDate));
                if ($fromDate<=date("Y-m-d")) {
                    $sql = "SELECT value FROM mgn_catalog_product_entity_datetime where attribute_id=(SELECT attribute_id FROM mgn_eav_attribute WHERE entity_type_id=4 AND ea.attribute_code='special_to_date')";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $toDate = $row["value"];
                        if (empty($toDate) || date("Y-m-d", strtotime($toDate))>=date("Y-m-d"))
                            $isSpecial = true;
                    }
                }
            }
        }
        if (!$isSpecial)
            $sprice = "";
    }
    return $sprice;
}
/*** function - get name,brand,prices,image,url_key etc. attributes data ***/
function getAttributesData($productId, $imageUrl, $conn)
{
    $data = array('name' => '', 'brand' => '', 'price' => '', 'special_price' => '', 'rule_price' => '', 'image' => '', 'url_key' => '');

    // get product name
    $sql = "SELECT value FROM mgn_catalog_product_entity_varchar WHERE entity_id=".$productId." AND attribute_id=".$_SESSION['attribute_id_name'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data['name'] = $row["value"];
    }

    // get product's brand
    $sql = "SELECT value FROM mgn_catalog_product_entity_varchar WHERE entity_id=".$productId." AND attribute_id=".$_SESSION['attribute_id_display_brand'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data['brand'] = $row["value"];
    }

    // get all prices
    $sql = "SELECT value FROM mgn_catalog_product_entity_decimal WHERE entity_id=".$productId." AND attribute_id=".$_SESSION['attribute_id_price'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data['price'] = $row["value"];
    }
    $sql = "SELECT rule_price FROM mgn_catalogrule_product_price WHERE product_id=".$productId." LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data['rule_price'] = $row["rule_price"];
    }
    if (empty($data['rule_price'])) {
        $data['special_price'] = getSpecialPrice($productId, $conn);
    }

    // get image
    $sql = "SELECT value FROM mgn_catalog_product_entity_varchar WHERE entity_id=(SELECT product_id FROM mgn_catalog_product_super_link where parent_id=".$productId." limit 1) AND attribute_id=".$_SESSION['attribute_id_small_image'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["value"] = str_replace("./", "", $row["value"]);
        $row["value"] = str_replace("-1", "-28", $row["value"]);
        $data['image'] = $imageUrl.$row["value"];
    }

    // get url_key
    $sql = "SELECT value FROM mgn_catalog_product_entity_url_key WHERE entity_id=".$productId;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["value"] = str_replace("./", "", $row["value"]);
        $data['url_key'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).$row["value"].".html";
    }

    return $data;
}
/*** function - store dkcart cookie data into session ***/
function getDataFromCookie($cookie, $imageUrl, $conn)
{
    $cookie = json_decode($cookie, true);
    foreach ($cookie as $item) {
        //$name = $brand = $price = $sprice = $rprice = $image = "";
        $attributeData = getAttributesData($item['id'], $imageUrl, $conn);

        $attributeValue80 = $attributeValue125 = $option80 = $option125 = "";
        if (!empty($item['child_product_id'])) {
            $sql = "SELECT `link_table`.`product_id`, `at_color`.`value` AS `color`, `at_size`.`value` AS `size` FROM `mgn_catalog_product_entity` AS `e`
                                  INNER JOIN
                            `mgn_catalog_product_super_link` AS `link_table` ON link_table.product_id = e.entity_id
                                  INNER JOIN
                            `mgn_catalog_product_entity_int` AS `at_color` ON (`at_color`.`entity_id` = `e`.`entity_id`) AND (`at_color`.`attribute_id` = '80') AND (`at_color`.`store_id` = 0)
                                  INNER JOIN
                            `mgn_catalog_product_entity_int` AS `at_size` ON (`at_size`.`entity_id` = `e`.`entity_id`) AND (`at_size`.`attribute_id` = '125') AND (`at_size`.`store_id` = 0)
                        WHERE (link_table.product_id = " . $item['child_product_id'] . ")";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $item['attributes'][0] = $row['color'];
                $item['attributes'][1] = $row['size'];
            }
        }
        if (isset($item['attributes'][0]) && !empty($item['attributes'][0])) {
            $sql = "SELECT value FROM mgn_eav_attribute_option_value WHERE option_id=".$item['attributes'][0];
            $resultColor = $conn->query($sql);
            if ($resultColor->num_rows > 0) {
                $option80 = $item['attributes'][0];
                $row = $resultColor->fetch_assoc();
                $attributeValue80 = $row['value'];
            }
        }
        if (isset($item['attributes'][1]) && !empty($item['attributes'][1])) {
            $sql = "SELECT value FROM mgn_eav_attribute_option_value WHERE option_id=".$item['attributes'][1];
            $resultColor = $conn->query($sql);
            if ($resultColor->num_rows > 0) {
                $option125 = $item['attributes'][1];
                $row = $resultColor->fetch_assoc();
                $attributeValue125 = $row['value'];
            }
        }
        $attributes = array($attributeValue80, $attributeValue125);
        $_SESSION['cart'][] = array('id' => $item['id'], 'name' => $attributeData['name'], 'display_brand' => $attributeData['brand'], 'qty' => $item['qty'], 'price' => $attributeData['price'], 'special_price' => $attributeData['special_price'], 'rule_price' => $attributeData['rule_price'], 'attributes' => $attributes, 'option80' => $option80, 'option125' => $option125, 'image' => $attributeData['image'], 'url_key' => $attributeData['url_key'], 'child_product_id' => $item['child_product_id'], 'giftcard' => $item['giftcard']);
    }
}
/*** function - store cart seesion data into dkcart cookie when customer not logged-in ***/
function setCartCookie()
{
    $cookieValue = array();
    foreach ($_SESSION['cart'] as $item) {
        $cookieValue[] = array('id' => $item['id'], 'qty' => $item['qty'], 'child_product_id' => $item['child_product_id'], 'giftcard' => $item['giftcard']);
    }
    $cookieValue = json_encode($cookieValue);
    setcookie("dkcart", $cookieValue, time() + (31536000), "/"); // one year
}
/*** function - add item to cart ***/
function addCartItem($customerId, $productId, $cartId, $qty, $attributeValue80, $attributeValue125, $superAttribute80, $superAttribute125, $imageUrl, $childProductId, $giftcard, $conn)
{
    //$name = $brand = $price = $sprice = $rprice = $image = "";
    $attributeData = getAttributesData($productId, $imageUrl, $conn);

    if (!empty($customerId)) {
        $attributeData['special_price'] = empty($attributeData['special_price']) ? 0 : $attributeData['special_price'];
        $priceStr = '{"price":'.$attributeData['price'].',"special_price":'.$attributeData['special_price'].',"rule_price":'.$attributeData['rule_price'].'}';
        $attributesStr = '{"'.$superAttribute80.'":"'.$attributeValue80.'","'.$superAttribute125.'":"'.$attributeValue125.'"}';
        $sql = "INSERT INTO mgn_dkcart_items (cart_id,product_id,child_product_id,qty,name,display_brand,price,image,url_key,attributes,giftcard) VALUES (".$cartId.",".$productId.",".$childProductId.",".$qty.",'".$attributeData['name']."','".$attributeData['brand']."','".$priceStr."','".$attributeData['image']."','".$attributeData['url_key']."','".$attributesStr."','".$giftcard."')";
        $conn->query($sql);
    }
    $attributes = array($attributeValue80, $attributeValue125);
    if (isset($_POST['key']) && !empty($_POST['key']))
        $_SESSION['cart'][$_POST['key']] = array('id' => $productId, 'name' => $attributeData['name'], 'display_brand' => $attributeData['brand'], 'qty' => $qty, 'price' => $attributeData['price'], 'special_price' => $attributeData['special_price'], 'rule_price' => $attributeData['rule_price'], 'attributes' => $attributes, 'option80' => $superAttribute80, 'option125' => $superAttribute125, 'image' => $attributeData['image'], 'url_key' => $attributeData['url_key'], 'child_product_id' => $childProductId, 'giftcard' => $giftcard);
    else
        $_SESSION['cart'][] = array('id' => $productId, 'name' => $attributeData['name'], 'display_brand' => $attributeData['brand'], 'qty' => $qty, 'price' => $attributeData['price'], 'special_price' => $attributeData['special_price'], 'rule_price' => $attributeData['rule_price'], 'attributes' => $attributes, 'option80' => $superAttribute80, 'option125' => $superAttribute125, 'image' => $attributeData['image'], 'url_key' => $attributeData['url_key'], 'child_product_id' => $childProductId, 'giftcard' => $giftcard);
}
/*** function - delete item from cart ***/
function deleteCartItem($id, $customerId, $cartId, $conn)
{
    if (isset($_SESSION['cart'][$id])) {
        if (!empty($customerId)) {
            if (!empty($_SESSION['cart'][$id]['giftcard'])) { // for giftcard product
                $sql = "DELETE FROM mgn_dkcart_items WHERE product_id=".$_SESSION['cart'][$id]['id']." AND cart_id=".$cartId." AND giftcard='".$_SESSION['cart'][$id]['giftcard']."'";
            } elseif(!empty($_SESSION['cart'][$id]['child_product_id'])) { // for configurable product
                $sql = "DELETE FROM mgn_dkcart_items WHERE product_id=".$_SESSION['cart'][$id]['id']." AND cart_id=".$cartId." AND child_product_id=".$_SESSION['cart'][$id]['child_product_id'];
            } else { // for simple product
                $sql = "DELETE FROM mgn_dkcart_items WHERE product_id=".$_SESSION['cart'][$id]['id']." AND cart_id=".$cartId;
            }
            $conn->query($sql);
        }
        unset($_SESSION['cart'][$id]);
    }
}
/*** function - update cart item ***/
function updateCartItem($customerId, $cartId, $conn)
{
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $qty = isset($_POST['qty']) ? $_POST['qty'] : 0;
    if (empty($qty)) { // delete item from cart when qty=0
        deleteCartItem($id, $customerId, $cartId, $conn);
    } else {
        if (!empty($_SESSION['cart'][$id]['giftcard'])) { // for giftcard product
            if (!empty($customerId)) {
                $sql = "UPDATE mgn_dkcart_items SET qty=" . $qty . " WHERE product_id=".$_SESSION['cart'][$id]['id']." AND cart_id=".$cartId." AND giftcard='".$_SESSION['cart'][$id]['giftcard']."'";
                $conn->query($sql);
            }
        }
        else {
            if (!empty($customerId)) {
                if (!empty($_SESSION['cart'][$id]['child_product_id'])) { // for configurable product
                    $productId = $_SESSION['cart'][$id]['child_product_id'];
                }
                else { // for simple product
                    $productId = $_SESSION['cart'][$id]['id'];
                }

                if (!empty($_SESSION['cart'][$id]['child_product_id']))
                    $sql = "UPDATE mgn_dkcart_items SET qty=".$qty." WHERE product_id=".$_SESSION['cart'][$id]['id']." AND child_product_id=".$productId." AND cart_id=".$cartId;
                else
                    $sql = "UPDATE mgn_dkcart_items SET qty=".$qty." WHERE product_id=".$_SESSION['cart'][$id]['id']." AND cart_id=".$cartId;
                $conn->query($sql);
            }
        }
        echo $_SESSION['cart'][$id]['qty'] = $qty;
    }
}
/*** function - get product's available quantity ***/
function checkProductsQty($id, $conn)
{
    if (isset($_SESSION['cart'][$id])) {
        if (!empty($_SESSION['cart'][$id]['child_product_id'])) { // for configurable product
            $productId = $_SESSION['cart'][$id]['child_product_id'];
        } else { // for simple product
            $productId = $_SESSION['cart'][$id]['id'];
        }
        $sql = "SELECT qty,stock_status FROM mgn_cataloginventory_stock_status WHERE product_id=".$productId;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['stock_status'] == 1 && $row['qty']>0) {
                if ($_SESSION['cart'][$id]['qty'] > $row['qty'])
                    $_SESSION['cart'][$id]['qty'] = $row['qty'];
                return $_SESSION['cart'][$id]['available_qty'] = intval($row['qty']);
            }
            else { //echo "Item is out of stock";
                $customerId = Mage::helper('customer')->getCustomer()->getId();
                if (empty($customerId)) {
                    $cartId = "";
                } else {
                    $sql = "SELECT cart_id FROM mgn_dkcart WHERE customer_id=".$customerId;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $cartId = $row["cart_id"];
                    }
                }
                deleteCartItem($id, $customerId, $cartId, $conn);
                return 0;
            }
        }
    }
}
/*** function - delete cart when there is no item into cart ***/
function deleteCart($customerId, $cartUpdate, $conn)
{
    if (!empty($customerId) && $cartUpdate) {
        $sql = "DELETE FROM mgn_dkcart WHERE customer_id=" . $customerId;
        $conn->query($sql);
    }
    unset($_SESSION['cart']);
    if (empty($customerId)) {
        setcookie("dkcart", "", time(), "/");
        unset($_COOKIE['dkcart']);
    }
}
/*** function - check pre-order attributes for cart item ***/
function checkPreOrderItem($productId)
{
    $conn = $_SESSION['conn'];
    $preOrderArray = array('whole_preorder'=>'', 'preorder_shipping_date'=>'');
    $sql = "SELECT value FROM mgn_catalog_product_entity_int WHERE entity_id=".$productId." AND attribute_id=".$_SESSION['attribute_id_whole_preorder'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $preOrderArray['whole_preorder'] = $row["value"];
    }
    $sql = "SELECT value FROM mgn_catalog_product_entity_varchar WHERE entity_id=".$productId." AND attribute_id=".$_SESSION['attribute_id_preorder_shipping_date'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $preOrderArray['preorder_shipping_date'] = $row["value"];
    }
    return $preOrderArray;
}
/*** function - prepare session (cart items) data ***/
function prepareCartData($customerId, $cartUpdate, $cookie, $imageUrl, $conn)
{
    $cartId = "";
    if (empty($customerId)) {
        if (!empty($cookie) && !isset($_SESSION['cart'])) { // for guest customer set data into session from cookie
            getDataFromCookie($cookie, $imageUrl, $conn);
        }
    }
    else {
        if (!empty($cookie)) { // delete cookie for logged-in customer
            setcookie("dkcart", "", time(), "/");
            unset($_COOKIE['dkcart']);
        }
        $sql = "SELECT cart_id FROM mgn_dkcart WHERE customer_id=".$customerId;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cartId = $row["cart_id"];
            if (!isset($_SESSION['cart']) || count($_SESSION['cart']) < 1) {
                $sql = "SELECT * FROM mgn_dkcart_items WHERE cart_id=".$cartId;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { // set data into session from database
                    while ($row = $result->fetch_assoc()) {
                        $attributes = array();
                        $option80 = $option125 = "";
                        $i = 0;
                        if (!empty($row['attributes'])) {
                            $attributesObj = json_decode($row['attributes']);
                            foreach ($attributesObj as $index=>$value) {
                                $attributes[] = $value;
                                if ($i==0) $option80 = $index;
                                if ($i==1) $option125 = $index;
                                $i++;
                            }
                        }
                        $price = json_decode($row['price']);
                        $_SESSION['cart'][] = array('id' => $row['product_id'], 'name' => $row['name'], 'display_brand' => $row['display_brand'], 'qty' => $row['qty'], 'price' => $price->price, 'special_price' => $price->special_price, 'rule_price' => $price->rule_price, 'attributes' => $attributes, 'option80' => $option80, 'option125' => $option125, 'image' => $row['image'], 'url_key' => $row['url_key'], 'child_product_id' => $row['child_product_id'], 'giftcard' => $row['giftcard']);
                    }
                }
            }
            else { // for logged-in customer insert data into database from session
                foreach ($_SESSION['cart'] as $item) {
                    if (!empty($item['giftcard'])) { // giftcard product
                        $sql = "SELECT item_id FROM mgn_dkcart_items WHERE product_id=".$item['id']." AND cart_id=".$cartId." AND giftcard='".$item['giftcard']."'";
                    } elseif (!empty($item['child_product_id'])) { // configurable product
                        $sql = "SELECT item_id FROM mgn_dkcart_items WHERE product_id=".$item['id']." AND cart_id=".$cartId." AND child_product_id=".$item['child_product_id'];
                    } else { // simple product
                        $sql = "SELECT item_id FROM mgn_dkcart_items WHERE product_id=".$item['id']." AND cart_id=".$cartId;
                    }
                    $result = $conn->query($sql);
                    if ($result->num_rows==0) {
                        $item['special_price'] = empty($item['special_price']) ? 0 : $item['special_price'];
                        $price = '{"price":'.$item['price'].',"special_price":'.$item['special_price'].',"rule_price":'.$item['rule_price'].'}';
                        $attributes = $attributeValue80 = $attributeValue125 = "";
                        if (isset($item['attributes'][0]))
                            $attributeValue80 = $item['attributes'][0];
                        if (isset($item['attributes'][1]))
                            $attributeValue125 = $item['attributes'][1];
                        if ((!empty($attributeValue80) || !empty($attributeValue125)) && (!empty($item['option80']) || !empty($item['option125'])))
                            $attributes = '{"'.$item['option80'].'":"'.$attributeValue80.'","'.$item['option125'].'":"'.$attributeValue125.'"}';
                        $sql = "INSERT INTO mgn_dkcart_items (cart_id,product_id,qty,name,display_brand,price,image,attributes,giftcard) VALUES (".$cartId.",".$item['id'].",".$item['qty'].",'".$item['name']."','".$item['display_brand']."','".$price."','".$item['image']."','".$attributes."','".$item['giftcard']."')";
                        $conn->query($sql);
                    }
                }
            }
        } elseif ($cartUpdate) {
            $sql = "INSERT INTO mgn_dkcart (customer_id,created_at) VALUES (".$customerId.",'".date('Y-m-d H:i:s')."')";
            $conn->query($sql);
            $cartId = $conn->insert_id;
        }
        return $cartId;
    }
}