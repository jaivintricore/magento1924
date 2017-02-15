<?php
include_once('config.php');

if (isset($_POST['country'])) {
    $_SESSION['country_id'] = $_POST['country'];
    $rates = getShippingMethods();
    if (isset($rates[0]))
        $_SESSION['current_shipping_method'] = $rates[0];
    $currentShippingMethod = isset($_SESSION['current_shipping_method']) ? $_SESSION['current_shipping_method'] : '';
    $shippingInfo = getShippingMethodsInfo($rates, $currentShippingMethod);
    echo json_encode($shippingInfo);
}
elseif (isset($_POST['code'])) {
    $_SESSION['current_shipping_method'] = $_POST['code'];
    $_SESSION['current_shipping_price'] = Mage::getStoreConfig("carriers/".$_POST['code']."/price");
}
elseif (isset($_POST['update'])) { //echo $_SESSION['current_shipping_method'].' - ';
    $rates = getShippingMethods();//exit($_SESSION['current_shipping_method']);
    if (!isset($_SESSION['current_shipping_method'])) {
        if (isset($rates[0])) {
            $_SESSION['current_shipping_method'] = $rates[0];
            $currentShippingMethod = $rates[0];
        }
    } else {
        $currentShippingMethod =  $_SESSION['current_shipping_method'];
    }
    $shippingInfo = getShippingMethodsInfo($rates, $currentShippingMethod);
    echo json_encode($shippingInfo);
}


/*** function - get shipping methods ***/
function getShippingMethods()
{
    $conn = $_SESSION['conn'];
    $shippingMethods = array();
    $sql = "SELECT value,path FROM mgn_core_config_data WHERE path like 'carriers/flatrate%/specificcountry'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!empty($row["value"])) {
                $countries = explode(",", $row["value"]);
                if (in_array($_SESSION['country_id'], $countries)) {
                    $pos = strpos($row["path"], "/");
                    $shippingCode = substr($row["path"], ($pos+1));
                    $shippingCode = substr($shippingCode, 0, (strpos($shippingCode, "/")));
                    $shippingMethods[] = $shippingCode;
                }
            }
        }
    }
    if (!isset($_SESSION['current_shipping_method']) && count($shippingMethods)>0) {
        $_SESSION['current_shipping_method'] = $shippingMethods[0];
    }
    return $shippingMethods;
}
/*** function - get html of shipping methods info ***/
function getShippingMethodsInfo($rates, $currentShippingMethod)
{
    $subtotal = $_POST['subtotal'];
    $shippingTitleInfo = "";
    $shippingRates = array();
    foreach ($rates as $rate) {
        $shippingRates[$rate] = array(
            "Title" => Mage::getStoreConfig("carriers/$rate/name"),
            "Price" => Mage::getStoreConfig("carriers/$rate/price"),
            "Code" => $rate,
            "FreeShippingEnable" => Mage::getStoreConfig("carriers/$rate/free_shipping_enable"),
            "FreeShippingSubtotal" => Mage::getStoreConfig("carriers/$rate/free_shipping_subtotal"),
            "ApplicableForFreeShipping" => Mage::getStoreConfig("carriers/$rate/applicable_free_shipping")
        );
    }
    $shippingTop = Mage::getStoreConfig("carriers/".$_SESSION['current_shipping_method']."/name");
    $shippingTop .= '<img class="cart_arrow_shipping_black" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'new_cart_assets/arrow_black_select.png" style="transform: rotate(180deg); margin-bottom: 1px; margin-left: 10px;" />';
    if ($shippingRates[$currentShippingMethod]['FreeShippingEnable']==1 && $shippingRates[$currentShippingMethod]['FreeShippingSubtotal'] != '' && ($shippingRates[$currentShippingMethod]['FreeShippingSubtotal']-$subtotal)>0 && $shippingRates[$currentShippingMethod]['ApplicableForFreeShipping']!='1') {
        $shippingTitleInfo = '<span class="shipping_title_info">&nbsp;Spend <price>'.Mage::helper('checkout')->formatPrice(Mage::helper('core')->currency($shippingRates[$currentShippingMethod]['FreeShippingSubtotal'],false,false) - $subtotal ).'</price> more to get free shipping! </span>';
    }
    $grandtotal = 0;
    if (($shippingRates[$currentShippingMethod]['FreeShippingEnable']==1 && $shippingRates[$currentShippingMethod]['FreeShippingSubtotal'] != '' && ($shippingRates[$currentShippingMethod]['FreeShippingSubtotal']-$subtotal)<=0)
        || ($shippingRates[$currentShippingMethod]['ApplicableForFreeShipping']=='1')) {
        $price = 0; //"Free";
        $_SESSION['current_shipping_price'] = 0;
    } else {
        $price = $shippingRates[$currentShippingMethod]['Price']; //Mage::helper('core')->currency($shippingRates[$currentShippingMethod]['Price'], true, false);
        $grandtotal = $subtotal + $shippingRates[$currentShippingMethod]['Price'];
        $_SESSION['current_shipping_price'] = $shippingRates[$currentShippingMethod]['Price'];
    }

    $list = '';
    foreach ($shippingRates as $shippingRate) {
        if (($shippingRate['FreeShippingEnable']==1 && $shippingRate['FreeShippingSubtotal'] != '' && ($shippingRate['FreeShippingSubtotal']-$subtotal)<=0) || ($shippingRate['ApplicableForFreeShipping']=='1')) {
            $displayRate = "Free";
            $rate = 0;
        } else {
            $displayRate = Mage::helper('core')->currency($shippingRate['Price'], true, false);
            $rate = $shippingRate['Price'];
        }
        $list .= '<li><input name="shipping_method" type="radio" value="'.$shippingRate['Code'].'" id="s_method_'.$shippingRate['Code'].'" onclick="changeShipping(this.value,\''.$rate.'\')"';
        if ($currentShippingMethod == $shippingRate['Code']) $list .= ' checked="checked"';
        $list .= '><label for="s_method_'.$shippingRate['Code'].'"><span id="shipping_label_'.$shippingRate['Code'].'">'.$shippingRate['Title'].'</span> - <span class="price" id="shipping_price_'.$shippingRate['Code'].'">';
        /*if (($shippingRate['FreeShippingEnable']==1 && $shippingRate['FreeShippingSubtotal'] != '' && ($shippingRate['FreeShippingSubtotal']-$subtotal)<=0) || ($shippingRate['ApplicableForFreeShipping']=='1')) {
            $list .= 'Free';
        } else {
            $list .= Mage::helper('core')->currency($shippingRate['Price'], true, false);
        }*/
        $list .= $displayRate.'</span></label>';
        if ($shippingRate['FreeShippingEnable']==1 && $shippingRate['FreeShippingSubtotal'] != '' && ($shippingRate['FreeShippingSubtotal']-$subtotal)>0 && $shippingRate['ApplicableForFreeShipping']!='1') {
            $list .= '<span id="shipping_title_info_'.$shippingRate['Code'].'" class="shipping_title_info">Free with&nbsp;<price>'.Mage::helper('core')->currency($shippingRate['FreeShippingSubtotal'],true,false).'</price> purchase! </span>';
        }
        $list .= '<div class="shipping_method_checkbox"></div></li>';
    }
    return array('shipping_top' => $shippingTop, 'shipping_title_info' => $shippingTitleInfo, 'shipping_list' => $list, 'shipping_price' => $price, 'grand_total' => $grandtotal, 'grandtotal_span' => Mage::helper('core')->currency($grandtotal,true,false));
}