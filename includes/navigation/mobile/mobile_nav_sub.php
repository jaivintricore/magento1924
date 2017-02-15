<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/navigation/db-config.php";
include_once($path);

$infParameter = "";
$isInfiniteScroll = 0;

$sql = "select * from `mgn_core_config_data` where `path` = 'dollskill_refinement/infinite_scroll/enable_infinite_scroll'";
$result = $db->query($sql);

while($row = $result->fetch_assoc()){
    $isInfiniteScroll = $row['value'];
}
if($isInfiniteScroll == 1) $infParameter = "&infscr_=1";
?>
<div class="new_top_nav new_mobile_nav">   
    <div class="submenu-wrapper" id="submenu1">
        <div class="sub-box-wrap">
            <ul class="submenu">
            	<li><p class="new_nav_sub"><a href="/whats-new.html">Shop All New</a></p></li>
                <li><p class="new_nav_sub"><a href="/whats-new.html?p_=1&c_=3-8&i_=our_favs&s_=http://www.dollskill.com/clothing.html<?php echo $infParameter; ?>">Clothing</a></p></li>
                <li><p class="new_nav_sub"><a href="/whats-new.html?p_=1&c_=20-8&i_=our_favs&s_=http://www.dollskill.com/shoes.html<?php echo $infParameter; ?>">Shoes</a></p></li>
                <li><p class="new_nav_sub"><a href="/whats-new.html?p_=1&c_=35-8&i_=our_favs&s_=http://www.dollskill.com/accessories.html<?php echo $infParameter; ?>">Accessories</a></p></li>
                <li><p class="new_nav_sub"><a href="/whats-new.html?p_=1&c_=39-8&i_=our_favs&s_=http://www.dollskill.com/makeup.html<?php echo $infParameter; ?>" >Beauty</a></p></li>
				<li class="col2">
                    <h3><a href style="text-decoration:none !important;">Our Faves</a></h3>
                    <ul>
                        <li><a href="/hott-in-stock.html">Hott in Stock</a></li>
                        <li><a href="/dollskill-best-sellers/pre-orderz.html">Pre-Order</a></li>
                        <li><a href="/shop/sugarbaby.html">Sugarbaby</a></li>
                        <li><a href="/shop/current-mood.html">Current Mood</a></li>
                    </ul>
                </li>
                
                <li class="col3">
                    <h3><a href="/lookz.html">Lookz</a></h3>
                    <ul>
                        <li><a href="/special-category/land-of-the-fairies.html">Dark Romance</a></li>
                        <li><a href="/special-category/motorcycle-babe.html">Metal Mayhem</a></li>
                        <li><a href="/shop/for-love-lemons.html">For Love and Lemons</a></li>
                        <li><a href="/dollskill-best-sellers/shoes-under-50.html">Shoe Spotlight - Under $50</a></li>
						<li><a href="/lookz.html">Shop All Lookz</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
          
	<div class="submenu-wrapper" id="submenu2">
        <div class="sub-box-wrap">
            <ul class="submenu">
                <!--li class="col7">
                    <h3><a href style="color:#00A435;">Holidaze</a></h3>
                    <ul>
                        <li><a href="/lookz/holiday-2016/clothing.html">Clothing</a></li>
                        <li><a href="/lookz/holiday-2016/winter-cozy-shoes.html">Shoes</a></li>
                        <li><a href="/lookz/holiday-2016/holiday-accessories.html">Accessories</a></li>
                        <li><a href="/lookz/holiday-2016/beauty.html" >Beauty</a></li>
                        <li><a href="/lookz/christmas.html">Shop All Holidaze</a></li>
                    </ul>
                </li-->
                <li class="col1">
                    <h3><a href>Clothing</a></h3>
                    <ul>
                        <li><a href="/clothing/tops.html">Tops</a></li>
                        <li><a href="/clothing/dresses.html">Dresses</a></li>
                        <li><a href="/clothing/bottoms.html">Bottoms</a></li>
                        <li><a href="/clothing/jumpsuits-rompers.html">Jumpsuits &amp; Rompers</a></li>
                        <li><a href="/clothing/outerwear.html">Outerwear</a></li>
                        <li><a href="/clothing/lingerie.html">Lingerie</a></li>
                        <li><a href="/clothing/active.html">Active</a></li> 
                        <li><a href="/clothing/swim.html">Swim</a></li>
						<li><a href="/clothing.html">Shop All Clothing</a></li>
                    </ul>
                </li>
                <li class="col2">
                    <h3><a href>Shoes</a></h3>
                    <ul>
                        <li><a href="/shoes/boots-booties.html">Boots &amp; Booties</a></li>
                        <li><a href="/shoes/platforms-wedges.html">Platforms &amp; Wedges</a></li>
                        <li><a href="/shoes/creepers.html">Creepers</a></li>
                        <li><a href="/shoes/heels.html">Heels</a></li>
                        <li><a href="/shoes/flats.html">Flats</a></li>
                        <li><a href="/shoes/platform-sneakers.html">Platform Sneakers</a></li>                        
                        <li><a href="/shoes/sneakers.html">Sneakers</a></li>
						<li><a href="/shoes.html">Shop All Shoes</a></li>
                    </ul>
                </li>
                
                <li class="col3">
                    <h3><a href>Accessories</a></h3>
                    <ul>
                        <li><a href="/accessories/bags-wallets.html">Bags &amp; Wallets</a></li>
                        <li><a href="/accessories/belts-harnesses.html">Belts &amp; Harnesses</a></li>
                        <li><a href="/accessories/jewelry.html">Jewelry</a></li>
                        <li><a href="/accessories/hats.html">Hats</a></li>
                        <li><a href="/accessories/hair-accessories.html">Hair Accessories</a></li>
                        <li><a href="/accessories/pins-patches.html">Pins &amp; Patches</a></li>
                        <li><a href="/accessories/toys-tech.html">Toys &amp; Tech</a></li>
                        <li><a href="/accessories/socks-tights.html">Socks &amp; Tights</a></li>
                        <li><a href="/accessories/home-stuff.html">Home Stuff</a></li>
                        <li><a href="/accessories/sunglasses.html">Sunglasses</a></li>
                        <li><a href="/accessories/scarves-gloves.html">Scarves &amp; Gloves</a></li>
                        <li><a href="/accessories/pets.html">Pets</a></li>
						<li><a href="/accessories.html">Shop All Accessories</a></li>
                    </ul>
                
                </li>
                
                <li class="col4">
                    <h3><a href>Beauty</a></h3>
                    <ul>
                        <li><a href="/beauty/lips.html">Lips</a></li>
                        <li><a href="/beauty/eyes.html">Eyes</a></li>
                        <li><a href="/beauty/nails.html">Nails</a></li>
                        <li><a href="/beauty/hair.html">Hair</a></li>
                        <li><a href="/beauty/tools.html">Tools</a></li>
                        <li><a href="/beauty/face-body.html">Face &amp; Body</a></li>
                        <li><a href="/beauty/pasties-tatts.html">Pasties &amp; Tatts</a></li>
						<li><a href="/beauty.html">Shop All Beauty</a></li>
                    </ul>
                </li>
                
                <li class="col5">
                    <h3><a href>Brands</a></h3>
                    <ul>
                        <li><a href="/shop/lime-crime.html">Lime Crime</a></li>
                        <li><a href="/shop/wildfox-couture.html">Wildfox Couture</a></li>
                        <li><a href="/shop/for-love-lemons.html">For Love &amp; Lemons</a></li>
                        <li><a href="/shop/y-r-u.html">Y.R.U.</a></li>
                        <li><a href="/shop/iron-fist.html">Iron Fist</a></li>
                        <li><a href="/shop/killstar.html">Killstar</a></li>
                        <li><a href="/shop/dr-martens.html">Dr. Martens</a></li>
                        <li><a href="/shop/current-mood.html">Current Mood</a></li>
                        <li><a href="/shop/sugarbaby.html">Sugarbaby</a></li>
                        <li><a href="/shop/demonia.html">Demonia</a></li>
                        <li><a href="/shop/lazy-oaf.html">Lazy Oaf</a></li>
                        <li><a href="/shop/ripndip.html">RIPNDIP</a></li>
						<li><a href="/shop-brands">Shop All Brands</a></li>
                    </ul>
                </li>
                
                <li class="col6">
                    <h3><a href>Dolls</a></h3>
                    <ul>
                        <li><a href="/dolls/festival-fashion.html">WILLOW</a></li>
                        <li><a href="/dolls/plur-rave-clothing.html">KANDI</a></li>
                        <li><a href="/dolls/gothic-clothing.html">MERCY</a></li>
                        <li><a href="/dolls/kawaii-clothing.html">COCO</a></li>
                        <li><a href="/dolls/punk-rock-clothing.html">DARBY</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
        
	<div class="submenu-wrapper" id="submenu4">
        <div class="sub-box-wrap">
            <ul class="submenu">
                <li><p class="new_nav_sub"><a href="/clearance.html">Shop All clearance</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/tops.html" >Tops</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/dresses.html" >Dresses</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/bottoms.html" >Bottoms</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/jumpsuits-rompers.html" >Jumpsuits &amp; Rompers</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/jackets.html" >Outerwear</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/lingerie.html" >Lingerie</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/swimwear.html">Swim</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/shoes.html">Shoes</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/accessories.html">Accessories</a></p></li>
                <li><p class="new_nav_sub"><a href="/clearance/beauty.html">Beauty</a></p></li>
            </ul>
        </div>
    </div>
</div>

<!-- for mobile navigation - to show dropdown - start -->
<script>
	jQuery("#submenu1").hide();
	jQuery("#submenu2").hide();
	jQuery("#submenu4").hide();
	
	jQuery(".new_nav_item1").on('click', function() {
		jQuery("#submenu2").hide();
		jQuery("#submenu4").hide();
		jQuery("#submenu1").toggle();
		
		jQuery(".new_nav_item1").toggleClass("clicked");
		
		jQuery("li.new_nav_item2").removeClass('clicked');
		jQuery("li.new_nav_item4").removeClass('clicked');
	});
	
	jQuery(".new_nav_item2").on('click', function() {
		jQuery("#submenu1").hide();
		jQuery("#submenu4").hide();
		jQuery("#submenu2").toggle();
		
		jQuery(".new_nav_item2").toggleClass("clicked");
		
		jQuery("li.new_nav_item1").removeClass('clicked');
		jQuery("li.new_nav_item4").removeClass('clicked');		
	});
	
	jQuery(".new_nav_item4").on('click', function() {
		jQuery("#submenu1").hide();
		jQuery("#submenu2").hide();
		jQuery("#submenu4").toggle();
		
		jQuery(".new_nav_item4").toggleClass("clicked");
		
		jQuery("li.new_nav_item1").removeClass('clicked');
		jQuery("li.new_nav_item2").removeClass('clicked');
	});
	
	
	jQuery(".submenu li").on('touchstart touchend', function(e){
		jQuery(this).toggleClass("hover_effect");
	});
	
	jQuery(".new_nav_sub").on('touchstart touchend', function(e){
		jQuery(this).toggleClass("hover_effect_menu");
	});

</script>
<!-- for mobile navigation - to show dropdown - end -->


<!-- for mobile navigation - js - start -->
<script>
	
	var width=jQuery(window).width();
	
	if(width<768){
		jQuery(function(){
			jQuery(".has-submenu").on("click touchstart", function(){
				jQuery(this).next('.submenu-wrapper').toggleClass('open');
			});
	
			var WindowsSize=function(){
				var w=jQuery(window).width();
				if(w<768){
					var y = jQuery('.submenu-wrapper ul li h3');
					y.first().addClass('activeM').next('ul').addClass('activeM');
					y.click(function(){
						if(jQuery(this).hasClass('activeM')){
							jQuery(this).removeClass('activeM');
							jQuery(this).next('ul').removeClass('activeM');
						}
						else{
							y.removeClass('activeM').next('ul').removeClass('activeM');
							jQuery(this).addClass('activeM');
							jQuery(this).next('ul').addClass('activeM');
						}
						return false;
					})
				}
			};
		
			WindowsSize();
	
		});
		
		jQuery(document).mouseup(function (e){
			var container = jQuery(".has-submenu");
			if (!container.is(e.target) && container.has(e.target).length === 0){
				container.removeClass('active');
				jQuery('.submenu-wrapper').removeClass('open');
			}
		});
	}
        
</script>
<!-- for mobile navigation - js - end --->
