<?php include($_SERVER["DOCUMENT_ROOT"].'/dkcart/main.php'); ?>
<!-- for new cart -- template -- start -->

<!-- include New Cart - Template CSS -- start -->
<?php
	include($_SERVER["DOCUMENT_ROOT"].'/includes/cart/cart_main_template_css.php');
?>
<!-- include New Cart - Template CSS -- end -->

<?php $totalItems = $totalQty = 0;
    if (isset($_SESSION['cart']) && count($_SESSION['cart'])>0) {
        $totalItems = count($_SESSION['cart']);
        foreach ($_SESSION['cart'] as $i=>$item) {
            $totalQty += $item['qty'];
        }
    }
?>
<div id="slider" class="slider" style="display: none;">

    <div class="cart_wrapper">
    	
        <!-- CART HEADER SECTION - START ----------------------------------------------------------------------------------- -->
        <div class="cart_header">
		    <p class="cart_top_title"><img id="cart_arrow_black" class="cart_arrow_black" src="<?php echo BASE_URL ?>media/new_cart_assets/arrow_black.jpg" /><span id="total_qty_span">Shopping Bag (<?php echo $totalQty ?>)</span></p>
        </div>
        <!-- CART HEADER SECTION - END ------------------------------------------------------------------------------------ -->
        
        
        <!-- CART HEADER SECTION - START ---------------------------------------------------------------------------------- -->
        <div class="cart_middle">
            <ul id="items_list" class="product_list">
			<?php if(isset($_SESSION['cart'])) { $subtotal = 0; //print_r($_SESSION['cart']);
				foreach ($_SESSION['cart'] as $i=>$item) { //print_r($item);
					if (!isset($item['available_qty'])) {
						$item['available_qty'] = checkProductsQty($i, $_SESSION['conn']);
						if(empty($item['available_qty'])) continue;
					}
                    $poriductId = $_SESSION['cart'][$i]['child_product_id'];
                    if (empty($poriductId)) $poriductId = $_SESSION['cart'][$i]['id'];
					?>
                <input type="hidden" class="items_list_child" id="<?php echo $poriductId ?>" value="<?php echo $i ?>" />
                <li id="item_row_<?php echo $i ?>" class="product-info_section">
                    <a href="<?php echo $item['url_key'] ?>" class="product-image">
                    	<img src="<?php echo $item['image'] ?>" width="80" height="114" alt="">
                    </a>
                    
                    <a href="#" onclick="return deleteItem('<?php echo $i ?>')" class="product-delete">
                    	<img src="<?php echo BASE_URL ?>media/new_cart_assets/icon_delete.jpg">
                    </a>
                    
                    <div class="product-info_details">
                        <div class="product-name_section">
                            <span class="manufacture_name"><?php echo $item['display_brand'] ?></span>
                            <a href="<?php echo $item['url_key'] ?>"><span class="product_name"><?php echo $item['name'] ?></span></a>
                        </div>
                		
                        <div class="product-options-color-size">
							<?php
							if(isset($item['attributes']) && !empty($item['attributes'])) {
								echo "<span>".implode(", ", $item['attributes'])."</span>";
							}
							?>
                        </div>
                        
                        <div class="product-qty-price">
                            <span>
                                <input type="hidden" id="sessionqty_<?php echo $i ?>" value="<?php echo $item['qty'] ?>">
                                <select name="qty_<?php echo $i ?>" id="qty_<?php echo $i ?>" class="size_custom_dropdown custom_scrollable" onchange="updateItem('<?php echo $i ?>',this.value)">
								<?php for($j=1; $j<=$item['available_qty']; $j++) { ?>
                                    <option value="<?php echo $j ?>" <?php echo ($item['qty']==$j) ? 'selected="selected"' : '' ?>><?php echo $j ?></option>
								<?php } ?>
                                </select>
                            </span>
                            <?php $price = 0;
							if (!empty($item['rule_price'])) {
								$price = $item['rule_price'];
								if ($item['rule_price']==$item['price'])
									echo '<span class="price_original">'.Mage::helper('core')->currency($item['price'], true, false).'</span>';
								else
									echo '<span class="price_original crossed">'.Mage::helper('core')->currency($item['price'], true, false).'</span><span class="price_sale">'.Mage::helper('core')->currency($item['rule_price'], true, false).'</span>';
							} elseif (!empty($item['special_price'])) {
								$price = $item['special_price'];
								echo '<span class="price_original crossed">'.Mage::helper('core')->currency($item['price'], true, false).'</span><span class="price_sale">'.Mage::helper('core')->currency($item['special_price'], true, false).'</span>';
							} else {
								$price = $item['price'];
								if (empty($price))
									echo '<span class="price_original">Free</span>';
								else
									echo '<span class="price_original">'.Mage::helper('core')->currency($item['price'], true, false).'</span>';
							}
							?>
                        </div>
                        <?php if(Mage::getSingleton('customer/session')->isLoggedIn()) { ?>
                        <div class="product-wishlist">
                        	<a href="#" onclick="addToWishlist()">
                                <img src="<?php echo BASE_URL ?>media/new_cart_assets/icon_heart.jpg" />
                                <span>Move to wishlist</span>
                            </a>
                        </div>
						<?php } $subtotal += ($price*$item['qty']); ?>
                    </div>
                </li>
            <?php }
			} else { ?>
                <li id="empty_cart" class="product-info_section">Cart is empty</li>
            <?php } ?>
            </ul>
        </div>
        <!-- CART MIDDLE SECTION - END ------------------------------------------------------------------------------------- -->

        <!-- CART FOOTER SECTION - START ----------------------------------------------------------------------------------- -->
        <div class="cart_footer">
            <div class="content">
                <ul id="totals">
                    <li>
                        <span class="subtotal_title">Subtotal</span>
                        <span class="subtotal_price" id="subtotal_span"><?php echo Mage::helper('core')->currency($subtotal, true, false) ?></span>
                    </li>
                    <?php $_SESSION['cart_subtotal'] = $subtotal ?>
                    <?php
						$style = "display:none";
						$val = 0;
						if(isset($_SESSION['discount_amount'])) {
							$style = "display:block";
							$val = $_SESSION['discount_amount'];
						}
						?>
                    <li id="discount" style="<?php echo $style; ?>">
						<span class="subtotal_title">Discount</span>
                        <span class="subtotal_price" id="discount_span"><?php echo Mage::helper('core')->currency($val, true, false) ?></span>
						?>
                    </li>

                <!-- SHIPPING METHODS SECTION - START ---------------------------------------------------------------------- -->
                <?php $showShipping = (isset($_SESSION['cart']) && count($_SESSION['cart'])>0) ? '' : 'display:none;'; ?>
                    <li id="shipping_methods" style="<?php echo $showShipping?>">
                        <ul>
                            <?php // shipping methods
                            $rates = getShippingMethods($_SESSION['conn']); //print_r($rates);
                            $currentShippingMethod = isset($_SESSION['current_shipping_method']) ? $_SESSION['current_shipping_method'] : '';
                            $shippingRates = array();
                            foreach ($rates as $rate) {
                                $shippingRates[$rate] = array(
                                    "Title" => Mage::getStoreConfig("carriers/$rate/name"),
                                    "Price" => Mage::getStoreConfig("carriers/$rate/price"),
                                    "Code" => $rate,
                                    "FreeShippingEnable" => Mage::getStoreConfig("carriers/$rate/free_shipping_enable"),
                                    "FreeShippingSubtotal" => Mage::getStoreConfig("carriers/$rate/free_shipping_subtotal"),
                                    "ApplicableForFreeShipping" => Mage::getStoreConfig("carriers/$rate/applicable_free_shipping"),
                                    //"OriginalShippingPrice" => Mage::getStoreConfig("carriers/$rate/price"),
                                    //"SortOrder" => Mage::getStoreConfig("carriers/$rate/sort_order")
                                );
                            }
                            ?>
                            <li>
                                <span id="shipping_title_top" class="shipping_title"><?php echo Mage::getStoreConfig("carriers/$currentShippingMethod/name"); ?><img class="cart_arrow_shipping_black" src="<?php echo BASE_URL ?>media/new_cart_assets/arrow_black_select.png" /></span>
                                <span class="shipping_price" id="shipping_price_top">
                                    <?php $grandtotal = $subtotal;
                                    if (($shippingRates[$currentShippingMethod]['FreeShippingEnable']==1 && $shippingRates[$currentShippingMethod]['FreeShippingSubtotal'] != '' && ($shippingRates[$currentShippingMethod]['FreeShippingSubtotal'] - $subtotal)<=0)
                                        || ($shippingRates[$currentShippingMethod]['ApplicableForFreeShipping']=='1')) {
                                        echo "Free";
                                        $_SESSION['current_shipping_price'] = 0;
                                    } else {
                                        echo Mage::helper('core')->currency($shippingRates[$currentShippingMethod]['Price'], true, false);
                                        $grandtotal += $shippingRates[$currentShippingMethod]['Price'];
                                        $_SESSION['current_shipping_price'] = $shippingRates[$currentShippingMethod]['Price'];
                                    }
                                    ?>
                                </span>
                            </li>
                            <li id="shipping_title_info">
                            <?php if ($shippingRates[$currentShippingMethod]['FreeShippingEnable']==1 && $shippingRates[$currentShippingMethod]['FreeShippingSubtotal'] != '' && ($shippingRates[$currentShippingMethod]['FreeShippingSubtotal']-$subtotal)>0 && $shippingRates[$currentShippingMethod]['ApplicableForFreeShipping']!='1') { ?>
                                <span class="shipping_title_info">&nbsp;Spend <price><?php echo Mage::helper('checkout')->formatPrice(Mage::helper('core')->currency($shippingRates[$currentShippingMethod]['FreeShippingSubtotal'],false,false) - $subtotal ) ?></price> more to get free shipping! </span>
                            <?php } ?>
                            </li>
                        </ul>
                        <ul class="shipping_extra_info_section">
                            <li>
								<span class="shipping_extra_info">
								<?php $countries = Mage::getResourceModel('directory/country_collection')->loadData()->toOptionArray(false);
                                if (count($countries) > 0): ?>
                                    <select name="country_id" id="country_id" class="shipping_extra_info" title="Country" onchange="changeCountry('<?php echo BASE_URL ?>',this.value)">
										<?php foreach($countries as $country): ?>
                                            <option value="<?php echo $country['value'] ?>" <?php if ($_SESSION['country_id'] == $country['value']) echo 'selected' ?>>	<?php echo $country['label'] ?> </option>
                                        <?php endforeach; ?>
									</select>
                                <?php endif; ?>
								</span>
                            </li>
                        </ul>
                        <ul id="shipping_list" class="shipping_extra_info_section">
							<?php foreach ($shippingRates as $shippingRate) {
										if (($shippingRate['FreeShippingEnable']==1 && $shippingRate['FreeShippingSubtotal'] != '' && ($shippingRate['FreeShippingSubtotal']-$subtotal)<=0)
                                            || ($shippingRate['ApplicableForFreeShipping']=='1')) {
                                            $displayRate = "Free";
                                            $rate = 0;
                                        } else {
                                            $displayRate = Mage::helper('core')->currency($shippingRate['Price'], true, false);
                                            $rate = $shippingRate['Price'];
                                        }
										?>
								<li>
									<input name="shipping_method" type="radio" value="<?php echo $shippingRate['Code'] ?>" id="s_method_<?php echo $shippingRate['Code'] ?>" <?php if ($currentShippingMethod == $shippingRate['Code']) echo 'checked="checked"' ?> onclick="changeShipping(this.value,'<?php echo $rate ?>')">
									<label for="s_method_<?php echo $shippingRate['Code'] ?>"><span id="shipping_label_<?php echo $shippingRate['Code'] ?>"><?php echo $shippingRate['Title'] ?></span> -
									<span class="price" id="shipping_price_<?php echo $shippingRate['Code'] ?>"> <?php echo $displayRate ?></span>
									</label>
                                    <?php
                                    if ($shippingRate['FreeShippingEnable']==1 && $shippingRate['FreeShippingSubtotal'] != '' && ($shippingRate['FreeShippingSubtotal']-$subtotal)>0 && $shippingRate['ApplicableForFreeShipping']!='1') { ?>
                                        <span id="shipping_title_info_<?php echo $shippingRate['Code'] ?>" class="shipping_title_info">Free with&nbsp;<price><?php echo Mage::helper('core')->currency($shippingRate['FreeShippingSubtotal'],true,false) ?></price> purchase! </span>
                                    <?php } ?>
                                    <div class="shipping_method_checkbox"></div>
								</li>
                            <?php } ?>
                            <!--<li>
                                <input name="shipping_method" type="radio" value="" checked="checked">
                                <label for="shipping_method_1"><span>Standard Shipping (2-3 days) - </span><span>$4.99</span></label>
                                <div class="shipping_method_checkbox"></div>
                            </li>-->

                        </ul>
                    </li>
                <?php if(!empty($showShipping)) { $grandtotal = $subtotal; } ?>
                <!-- SHIPPING METHODS SECTION - END ---------------------------------------------------------------------- -->

                    <li>
                        <span class="total_title">Total</span>
                        <span class="total_price" id="grandtotal_span"><?php echo Mage::helper('core')->currency($grandtotal, true, false) ?></span>
                    </li>
                </ul>
                <img src="<?php echo BASE_URL ?>media/new_cart_assets/button_apple_pay.jpg" />
                <img src="<?php echo BASE_URL ?>media/new_cart_assets/button_checkout.jpg" />
                <img src="<?php echo BASE_URL ?>media/new_cart_assets/button_paypal.jpg" />
                <p class="section_credit_store">Store Credit, Gift card or Promo Code?</p>
                
                <ul class="promo_store_credit_section">
                	<li class="credit_store_display">
                        <div class="credit_store_display_checkbox">
                            <input type="checkbox" value="None" id="credit_store_display_checkbox" name="check" checked />
                            <label for="credit_store_display_checkbox"></label>
                        </div>
                        <span>Apply Store Credit: <strong>$120.00</strong></span>
                    </li>
                    
                    <li>
                        <div class="field-wrapper">
                            <input class="input-text" type="text" id="coupon_code" name="coupon_code" placeholder="Enter code here">
                            <div class="button-wrapper">
                            	<button type="button" class="button2" onclick="applycode()" value="Apply"><span>Apply</span></button>
                            </div>
                        </div>
                    </li>
                </ul>
                
            </div>
        </div>
        <!-- CART FOOTER SECTION - END ------------------------------------------------------------------------------------- -->
    
    </div>

</div>
<span id="wishlist_span" style="display:none;">
    <?php if(Mage::getSingleton('customer/session')->isLoggedIn()) { ?><div class="product-wishlist"><a <a href="#" onclick="addToWishlist()"><img src="<?php echo BASE_URL ?>media/new_cart_assets/icon_heart.jpg"><span>Move to wishlist</span></a></div><?php } ?>
</span>
<?php $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol(); ?>
<input type="hidden" id="total_items" name="total_items" value="<?php echo $totalItems ?>" />
<input type="hidden" id="total_qty" name="total_qty" value="<?php echo $totalQty ?>" />
<input type="hidden" id="current_shipping_price" name="current_shipping_price" value="<?php echo $_SESSION['current_shipping_price'] ?>" />
<input type="hidden" id="grandtotal" name="grandtotal" value="<?php echo $grandtotal ?>" />
<input type="hidden" id="subtotal" name="subtotal" value="<?php echo $subtotal ?>" />
<!-- for new cart -- template -- end -->


<script type="text/javascript">
function applycode()
{
	var code = jQuery('#coupon_code').val();
	var formObj = new Object();
		formObj.code = code;
		
	jQuery.ajax({
		url: "<?php echo BASE_URL ?>dkcart/discount.php",
		data: formObj,
		type: 'post',
		dataType: 'json',
		success: function(response) {
			if(response.status) {
				
				jQuery('#discount_span').html(response.discount);
				jQuery('#discount').show();
			}
				
		},
	});
}
function changeCountry(url, country)
{
	var subtotal = $('subtotal').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
            $('shipping_methods').show();
			var data = JSON.parse(this.responseText);
			document.getElementById("shipping_title_top").innerHTML = data.shipping_top;
            document.getElementById("shipping_title_info").innerHTML = data.shipping_title_info;
			document.getElementById("shipping_list").innerHTML = data.shipping_list;
            $('current_shipping_price').value = data.shipping_price;
            if (data.shipping_price==0) {
                document.getElementById("shipping_price_top").innerHTML = "Free";
            } else {
                document.getElementById("shipping_price_top").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat(data.shipping_price).toFixed(2);
            }
			//document.getElementById("shipping_price_top").innerHTML = data.shipping_price;
            document.getElementById("grandtotal_span").innerHTML = data.grandtotal_span;
            document.getElementById("grandtotal").value = data.grand_total;
            //updateTotals();
		}
	};
	xhttp.open("POST", url+"dkcart/shipping.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("country="+country+"&subtotal="+subtotal);
}
function changeShipping(code, price)
{
    var url = '<?php echo BASE_URL ?>';
    jQuery.ajax({
        url: url+'dkcart/shipping.php',
        dataType: 'json',
        type: 'post',
        data: 'code='+code,
        success: function (data) { }
    });
    $('grandtotal').value = parseFloat($('grandtotal').value) - parseFloat($('current_shipping_price').value) + parseFloat(price);
    document.getElementById("grandtotal_span").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat($('grandtotal').value).toFixed(2);
    $('current_shipping_price').value = price;
    var toptitle = document.getElementById('shipping_label_'+code).innerHTML;
    toptitle = toptitle + '<img class="cart_arrow_shipping_black" src="'+url+'media/new_cart_assets/arrow_black_select.png" style="transform: rotate(180deg); margin-bottom: 1px; margin-left: 10px;" />';
    document.getElementById('shipping_title_top').innerHTML = toptitle;
    document.getElementById("shipping_price_top").innerHTML = document.getElementById("shipping_price_"+code).innerHTML;
    document.getElementById("shipping_title_info").innerHTML = '';
}
function addToWishlist()
{
    //alert($('product').value);  $('simple_productid').value
    return false;
}
function updateItem(id, qty)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //alert('Quantity updated successfully');
            updateTotals();
        }
    };
    xhttp.open("POST", "<?php echo BASE_URL ?>dkcart/main.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=update&id="+id+"&qty="+qty);
    $('total_qty').value = parseInt($('total_qty').value) - parseInt($('sessionqty_'+id).value);
    $('total_qty').value = parseInt($('total_qty').value) + parseInt(qty);
    $('total_qty_span').innerHTML = 'Shopping Bag ('+$('total_qty').value+')';
    $('sessionqty_'+id).value = qty;
}
function deleteItem(id)
{
    var totalitems = $('total_items').value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (totalitems>1) {
                updateTotals();
            } else {
                $('subtotal').value = "0";
                document.getElementById("subtotal_span").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat(0).toFixed(2);
                $('grandtotal').value = "0";
                document.getElementById("grandtotal_span").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat(0).toFixed(2);
                $('shipping_methods').hide();
            }
        }
    };
    xhttp.open("POST", "<?php echo BASE_URL ?>dkcart/main.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=delete&id="+id);
    //$('item_row_'+id).innerHTML = "";
    if (totalitems>1) {
        $('total_items').value = parseInt(totalitems) - 1;
        $('total_qty').value = parseInt($('total_qty').value) - parseInt($('qty_'+id).value);
        $('total_qty_span').innerHTML = 'Shopping Bag ('+$('total_qty').value+')';
    } else {
        $('items_list').innerHTML = '<li id="empty_cart" class="product-info_sectio">Cart is empty</li>';
        $('total_qty_span').innerHTML = 'Shopping Bag (0)';
        $('total_items').value = 0;
        $('total_qty').value = 0;
        $('shipping_methods').hide();
    }
    $('item_row_'+id).remove();
    return false;
}
function addToCustomCart()
{
	var validator = new Validation($('product_addtocart_form'));
	if (validator.validate()) {
        var attr80 = $('attribute80').value;
        var attr125 = $('attribute125').value;
        var key = $('key').value+attr80+attr125;
		var data = jQuery('#product_addtocart_form').serialize(); //alert(data);
        data += '&super_attribute_80='+attr80+'&super_attribute_125='+attr125+'&key='+key;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                updateTotals();
            }
        };
        xhttp.open("POST", "<?php echo BASE_URL ?>dkcart/main.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(data);

        if (eval($('empty_cart'))!=null)
            $('empty_cart').hide();

        var list = document.getElementById("items_list");
        var child = list.getElementsByClassName("items_list_child");
        var pid = '';
        var itemKey = '';
        var currentPid = $('simple_productid').value;
        for (var i=0; i<child.length; i++) {
            pid = child[i].id;
            if (currentPid==pid)
                itemKey = child[i].value;
        }
        if (itemKey!='') {
            var html = document.getElementById('item_row_'+itemKey).innerHTML;
            $('item_row_'+itemKey).remove();
            key = itemKey;
        } else {
            $('total_items').value = parseInt($('total_items').value)+1;
            var html = '<input type="hidden" class="items_list_child" id="'+currentPid+'" value="'+key+'" />';
            html += itemHtml($('key').value, key);
        }
        $('total_qty').value = parseInt($('total_qty').value)+1;
        $('total_qty_span').innerHTML = 'Shopping Bag ('+$('total_qty').value+')';

        var node = document.createElement("li"); // Create new <li> node
        node.setAttribute('id', 'item_row_' + key);
        node.className = "product-info_section";
        node.innerHTML = html;
        $("items_list").insertBefore(node, $("items_list").childNodes[1]); // insert new item row
        if (itemKey!='') {
            $('qty_'+key).value = parseInt($('qty_'+key).value)+1;
        }
        $('sessionqty_'+key).value = $('qty_'+key).value;

        jQuery("#slider").slideReveal("show"); // show custom cart slider
	}
}
function itemHtml(key, keyid)
{
    var url = $('url_'+key).value;
    var baseUrl = '<?php echo BASE_URL ?>';
    var price = $('price_'+key).value;
    var specialPrice = $('sprice_'+key).value;
    var rulePrice = $('rprice_'+key).value;

    var html = '<a href="'+url+'" class="product-image"><img src="'+$('image_'+key).value+'" alt="" width="80" height="114"></a>';
    html += '<a href="#" onclick="return deleteItem(\''+keyid+'\')" class="product-delete"><img src="'+baseUrl+'media/new_cart_assets/icon_delete.jpg"></a>';
    html += '<div class="product-info_details">';
    html += '<div class="product-name_section"><span class="manufacture_name">'+$('brand_'+key).value+'</span><a href="'+url+'"><span class="product_name">'+$('name_'+key).value+'</span></a></div>';
    html += '<div class="product-options-color-size"><span>'+$('attributes_'+key).value+'</span></div>';
    html += '<div class="product-qty-price">';
    html += '<span><input type="hidden" id="sessionqty_'+keyid+'" value="1"><select name="qty_'+keyid+'" id="qty_'+keyid+'" class="size_custom_dropdown custom_scrollable" onchange="updateItem(\''+keyid+'\',this.value)">';
    for (var i=1;i<=$('totalqty_'+key).value;i++) {
        html += '<option value="'+i+'">'+i+'</option>';
    }
    html += '</select></span>';
    if (specialPrice=="$0.00") {
        if (rulePrice==price)
            html += '<span class="price_original">'+price+'</span>';
        else
            html += '<span class="price_original crossed">'+price+'</span><span class="price_sale">'+rulePrice+'</span>';
    } else {
        if (rulePrice!="$0.00")
            html += '<span class="price_original crossed">'+price+'</span><span class="price_sale">'+specialPrice+'</span>';
        else
            html += '<span class="price_original crossed">'+price+'</span><span class="price_sale">'+rulePrice+'</span>';
    }
    html += '</div>';
    html += document.getElementById('wishlist_span').innerHTML;
    html += '</div>';
    return html;
}
function updateTotals()
{
    var url = '<?php echo BASE_URL ?>dkcart/ajax.php';
    jQuery.ajax({
        url: url,
        dataType: 'json',
        type: 'post',
        success: function (data) {
            $('subtotal').value = data.subtotal;
            updateShipping();
            document.getElementById("subtotal_span").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat(data.subtotal).toFixed(2);
            //$('grandtotal').value = data.grandtotal;
            //document.getElementById("grandtotal_span").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat(data.grandtotal).toFixed(2);
        }
    });
}
function updateShipping()
{
    var url = '<?php echo BASE_URL ?>';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('shipping_methods').show();
            var data = JSON.parse(this.responseText);
            document.getElementById("shipping_title_top").innerHTML = data.shipping_top;
            document.getElementById("shipping_title_info").innerHTML = data.shipping_title_info;
            document.getElementById("shipping_list").innerHTML = data.shipping_list;
            $('current_shipping_price').value = data.shipping_price;
            if (data.shipping_price==0) {
                document.getElementById("shipping_price_top").innerHTML = "Free";
            } else {
                document.getElementById("shipping_price_top").innerHTML = '<?php echo $currencySymbol ?>' + parseFloat(data.shipping_price).toFixed(2);
            }
            $('shipping_methods').show();
            document.getElementById("grandtotal_span").innerHTML = data.grandtotal_span;
            document.getElementById("grandtotal").value = data.grand_total;
        }
    };
    xhttp.open("POST", url+"dkcart/shipping.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("update=yes&subtotal="+$('subtotal').value);
}
</script>
