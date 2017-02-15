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
<!-- 12-23-16 -->

<style>
    #nav-box #nav .nav-primary.not-mobile {
        display:none !important;
    }
    
    @media (min-width:768px) {
        .new_desktop_nav {opacity:1 !important;}
        .new_mobile_nav {opacity:0 !important; display:none !important;}
    }
    
    @media (max-width:767px) {
        .new_desktop_nav { opacity:0 !important;}
        .new_mobile_nav {opacity:1 !important;}
        .new_top_nav.new_desktop_nav {display:none !important;} 
    }
</style>

<!-- for previous mobile nav -- start -->
<?php //echo $this->getChildHtml('topMenu') ?>
<!-- for previous mobile nav -- end -->
        
<!-- new navigation --  start -->
<style>
            
.new_top_nav { 
    position: absolute; 
    z-index: 54; 
    bottom: 0px; 
    left: 0; 
    padding-top: 4px; 
    margin: 0; 
    display: inline-block; 
    margin: -5px;
}

.new_top_nav span { 
    font-family: 'proxima-nova-sc-osf-ext-cond', Arial, 'BebasRegular', sans-serif; 
    font-size: 24px; 
    font-weight: 400; 
    text-decoration: none !important; 
    padding: 0; 
    line-height: 100%; 
    display: inline; 
    float: none; 
    color: #fff; 
    text-transform: uppercase; 
    text-align: left; 
}

.new_top_nav a:active { 
    text-decoration: none;               
}

.new_top_nav li { 
    /* Bobby requested for the following*/
    padding: 17px 12px 10px; vertical-align: bottom; float: left; text-align: center;
}

li.new_nav_item1:hover, li.new_nav_item2:hover, li.new_nav_item3:hover, li.new_nav_item4:hover, li.new_nav_item5:hover { 
    background-color: #262626; cursor: pointer; 
}
            
/* For Doll Menu settings - start */
.new_nav_item3 .sub-box-wrap { 
    padding:20px 0 0 !important; 
}
.new_nav_item3 ul li {
    vertical-align: bottom !important;
    padding: 0 !important;
    display:table-cell !important;
}
.new_nav_item3 .submenu {
    text-align: -webkit-center !important;
    text-align: -moz-center !important;
}
/* For Doll Menu settings - end */
            

.submenu { 
    background-color: #262626; margin: 0px auto; 
}

.submenu li { 
    width: 51%; max-width: 1600px; text-align: left !important; 
}

.submenu-wrapper { 
    left: 0; top: 80px; margin: 0 auto; position: fixed; background-color: #262626; z-index: 20; width: 100%; -ms-transition: all 0.4s ease-in-out; -o-transition: all 0.4s ease-in-out; -moz-transition: all 0.4s ease-in-out; -webkit-transition: all 0.4s ease-in-out; transition: all 0.4s ease-in-out; text-align: center; display: none; 
}

.submenu-wrapper .sub-box-wrap { 
    position: relative; 
    max-width: 100%; 
    padding: 20px 0 20px; 
}
            
.submenu-wrapper ul li { display: inline-block; vertical-align:top; min-width: 160px; width: 210px; float: none; padding: 5px 0; font-size: 13px; }
            
.submenu-wrapper ul li a { color: #fff; }
.submenu-wrapper ul li a:hover { text-decoration: underline !important; }
.submenu-wrapper ul li a:hover img { opacity: 0.7; }
            
.submenu-wrapper ul li h3 { color: #fff; /*font-size: 24px;*/ margin: 0 0 10px; line-height: 20px; font: 1.3em/1.3em 'proxima-nova-sc-osf-ext-cond', Arial, 'BebasRegular', sans-serif;}
.submenu-wrapper ul li h3 a { font: 1.3em/1.3em 'proxima-nova-sc-osf-ext-cond', Arial, 'BebasRegular', sans-serif; }
.submenu-wrapper ul li.box-figure { text-align: center !important; }
            
.submenu-wrapper ul li.box-figure img { margin: 0 auto; }
.submenu-wrapper ul li.box-figure img:hover { opacity: 0.7; }
            
.submenu-wrapper ul li.box-figure span { font-family: "Helvetica Neue", Verdana, Arial, sans-serif; font-size: 13px; line-height: 16px; text-transform: none; margin: 6px 0 0; display: inline-block; }
            
.box-figure a:hover span { text-decoration: underline !important; }
            
.header-transition-scroll .submenu-wrapper { top: 49px; }
.new_nav_item1 .submenu-wrapper ul li { max-width: 160px; }
.new_nav_item1 .submenu-wrapper ul li.box-figure, .new_nav_item4 .submenu-wrapper ul li.box-figure, .new_nav_item5 .submenu-wrapper ul li.box-figure { max-width: 200px; }

.submenu-wrapper.open, .new_top_nav li:hover .submenu-wrapper{ display:block;}

@media (max-width:1115px) {
    .new_nav_item1 .submenu-wrapper ul li.col6 { display: none; }
}

            
@media (min-width:768px ) AND (max-width:1189px) {
    .submenu-wrapper ul li.col5.box-figure { display: none; }
}

@media (min-width:768px ) AND (max-width:825px) {
    .new_nav_item5 {display:none;}
    #halloween_under_shop {display:block !important;}
}

@media (min-width:768px) AND (max-width:1160px) {
    .new_nav_item2 .submenu-wrapper ul li, .new_nav_item3 .submenu-wrapper ul li {width: /*14vw*/ 18vw; }
}
            
@media (max-width:870px) {
    .submenu-wrapper ul li.col5 { display: none; }
    .submenu-wrapper ul li.col4.box-figure { display: none; }
}

/*For hover clickable all around in the top menu  - start */
li.new_nav_item1:hover .has-submenu, li.new_nav_item2:hover .has-submenu, li.new_nav_item3:hover .has-submenu, li.new_nav_item4:hover .has-submenu, li.new_nav_item5:hover .has-submenu { 
    padding: 17px 12px 10px;
    vertical-align: bottom;
    display: inline-block; 
}

li.new_nav_item1:hover, li.new_nav_item2:hover, li.new_nav_item3:hover, li.new_nav_item4:hover, li.new_nav_item5:hover { 
    padding: 0 0 0;
}       
/*For hover clickable all around in the top menu  - end */

</style>

                    
<!-- for new mobile nav -- start -->
<?php 
    include($root.'/includes/navigation/mobile/mobile_nav.php'); 
?>
<!-- for new mobile nav -- end -->


<!-- the following style is for touch control on ipad -- start -->
<style>
    #nav > a
    {
        display: none;
    }
</style>
<a href="#nav" title="Show navigation">Show navigation</a>
<a href="#" title="Hide navigation">Hide navigation</a>
<!-- the following style is for touch control on ipad -- end -->


<ul class="new_top_nav new_desktop_nav">
    <li class="new_nav_item1">
        <a href="/whats-new.html"><span class="has-submenu">What's New</span></a>
        <div class="submenu-wrapper">
            <div class="sub-box-wrap">
            <ul class="submenu">
                <li class="col1">
                    <h3><a href="/whats-new.html">What's New</a></h3>
                    <ul>
                        <li><a href="/whats-new.html?p_=1&c_=3-8&i_=our_favs&s_=http://www.dollskill.com/clothing.html<?php echo $infParameter; ?>">Clothing</a></li>
                        <li><a href="/whats-new.html?p_=1&c_=20-8&i_=our_favs&s_=http://www.dollskill.com/shoes.html<?php echo $infParameter; ?>" >Shoes</a></li>
                        <li><a href="/whats-new.html?p_=1&c_=35-8&i_=our_favs&s_=http://www.dollskill.com/accessories.html<?php echo $infParameter; ?>" >Accessories</a></li>
                        <li><a href="/whats-new.html?p_=1&c_=39-8&i_=our_favs&s_=http://www.dollskill.com/makeup.html<?php echo $infParameter; ?>" >Beauty</a></li>
                    </ul>
                </li>
                
                <li class="col2">
                    <h3><a style="text-decoration:none !important;">Our Faves</a></h3>
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
                    </ul>
                
                </li>

                <li class="col4 box-figure">
                    <div class="box1">
                        <a href="/special-category/land-of-the-fairies.html"><img src="/media/menu/dark-fairy.jpg" alt=""><span>Dark Romance</span></a>
                    </div>
                </li>
                <li class="col5 box-figure">
                    <div class="box2">
                        <a href="/special-category/motorcycle-babe.html"><img src="/media/menu/metal_mayhem.jpg" alt=""><span>Metal Mayhem</span></a>
                    </div>
                </li>
                <li class="col6 box-figure">
                    <div class="box3">
                        <a href="/shop/for-love-lemons.html"><img src="/media/menu/flal.jpg" alt=""><span>For Love and Lemons</span></a>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </li>
    
    <li class="new_nav_item2">
        <span class="has-submenu">Shop</span>
        <div class="submenu-wrapper">
            <div class="sub-box-wrap">
                <ul class="submenu">
                <li class="col1">
                    <h3><a href="/clothing.html">Clothing</a></h3>
                    <ul>
                        <li><a href="/clothing/tops.html" >Tops</a></li>
                        <li><a href="/clothing/dresses.html" >Dresses</a></li>
                        <li><a href="/clothing/bottoms.html" >Bottoms</a></li>
                        <li><a href="/clothing/jumpsuits-rompers.html" >Jumpsuits &amp; Rompers</a></li>
                        <li><a href="/clothing/outerwear.html" >Outerwear</a></li>
                        <li><a href="/clothing/lingerie.html" >Lingerie</a></li>
                        <li><a href="/clothing/active.html">Active</a></li> 
                        <li><a href="/clothing/swim.html">Swim</a></li>     
                    </ul>
                </li>
                
                <li class="col2">
                    <h3><a href="/shoes.html">Shoes</a><a style="text-decoration:none !important; float:none;" href="/shoes.html">&nbsp;</a></h3>
                    <ul>
                        <li><a href="/shoes/boots-booties.html">Boots &amp; Booties</a></li>
                        <li><a href="/shoes/platforms-wedges.html">Platforms &amp; Wedges</a></li>
                        <li><a href="/shoes/creepers.html">Creepers</a></li>
                        <li><a href="/shoes/heels.html">Heels</a></li>
                        <li><a href="/shoes/flats.html">Flats</a></li>
                        <li><a href="/shoes/platform-sneakers.html">Platform Sneakers</a></li>                        
                        <li><a href="/shoes/sneakers.html">Sneakers</a></li>
                    </ul>
                </li>
                
                <li class="col3">
                    <h3><a href="/accessories.html">Accessories</a></h3>
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
                    </ul>
                
                </li>
                
                <li class="col4">
                    <h3><a href="/beauty.html">Beauty</a></h3>
                    <ul>
                        <li><a href="/beauty/lips.html">Lips</a></li>
                        <li><a href="/beauty/eyes.html">Eyes</a></li>
                        <li><a href="/beauty/nails.html">Nails</a></li>
                        <li><a href="/beauty/hair.html">Hair</a></li>
                        <li><a href="/beauty/tools.html">Tools</a></li>
                        <li><a href="/beauty/face-body.html">Face &amp; Body</a></li>
                        <li><a href="/beauty/pasties-tatts.html">Pasties &amp; Tatts</a></li>
                    </ul>
                
                </li>
                
                <li class="col5">
                    <h3><a href="/shop-brands">Brands</a></h3>
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
                    </ul>
                </li>
                
            </ul>
            </div>
        </div>
    </li>
    
    <li class="new_nav_item3">
        <a href="/dolls.html"><span class="has-submenu">Dolls</span></a>
        <div class="submenu-wrapper">
            <div class="sub-box-wrap">
            <ul class="submenu">
                
            <li class="col1">
                <ul>
                    <li><a href="/dolls/festival-fashion.html"><img src="/media/menu/Nav_Willow_LG@2x.jpg" alt=""></a></li>
                </ul>
            </li>
            
            <li class="col2">
                <ul>
                    <li><a href="/dolls/plur-rave-clothing.html"><img src="/media/menu/Nav_Kandi_LG@2x.jpg" alt=""></a></li>
                </ul>
            </li>
            
            <li class="col3">
                <ul>
                    <li><a href="/dolls/gothic-clothing.html"><img src="/media/menu/Nav_Mercy_LG@2x.jpg" alt=""></a></li>
                </ul>
            
            </li>
            
            <li class="col4">
                <ul>
                    <li><a href="/dolls/kawaii-clothing.html"><img src="/media/menu/Nav_Coco_LG@2x.jpg" alt=""></a></li>
                </ul>
            
            </li>
            
            <li class="col5">
                <ul>
                    <li><a href="/dolls/punk-rock-clothing.html"><img src="/media/menu/Nav_Darby_LG@2x.jpg" alt=""></a></li>
                </ul>
            </li>
                
            </ul>
            </div>
        </div>
    </li>
    
    <li class="new_nav_item4">
        <a href="/clearance.html"><span class="has-submenu" style="color:#ff0000;">Clearance</span></a>
        <div class="submenu-wrapper">
            <div class="sub-box-wrap">
            <ul class="submenu">
                <li class="col1">
                    <h3><a href="/clearance.html">clearance</a></h3>
                    <ul>
                        <li><a href="/clearance/tops.html" >Tops</a></li>
                        <li><a href="/clearance/dresses.html" >Dresses</a></li>
                        <li><a href="/clearance/bottoms.html" >Bottoms</a></li>
                        <li><a href="/clearance/jumpsuits-rompers.html" >Jumpsuits &amp; Rompers</a></li>
                        <li><a href="/clearance/jackets.html" >Outerwear</a></li>
                        <li><a href="/clearance/lingerie.html" >Lingerie</a></li>
                        <li><a href="/clearance/swimwear.html">Swim</a></li>
                        <li><a href="/clearance/shoes.html">Shoes</a></li>
                        <li><a href="/clearance/accessories.html">Accessories</a></li>
                        <li><a href="/clearance/beauty.html">Beauty</a></li>
                    </ul>
                </li>

                <li class="col2">
                    <h3><a style="text-decoration:none !important;">Featured</a></h3>
                    <ul>
                        <li><a href="/clearance/hexed-lolita.html">Hexed Lolita</a></li>
                        <li><a href="/clearance/just-added.html">Just Added</a></li>
                        <li><a href="/clearance/under-25.html">Under $25</a></li>
                        <li><a href="/clearance/buy-now-cry-later.html">Last Chance to Buy</a></li>
                        <li><a href="/clearance/further-markdownz.html">Further Markdownz</a></li>
                    </ul>
                </li>

                <li class="col3 box-figure">
                    <div class="box1">
                        <a href="/clearance/hexed-lolita.html"><img src="/media/menu/HEXED_LOLITA.jpg" alt=""><span>Hexed Lolita</span></a>
                    </div>
                </li>
                <li class="col4 box-figure">
                    <div class="box2">
                        <a href="/clearance/just-added.html"><img src="/media/menu/JUST_ADDED.jpg" alt=""><span>Just Added</span></a>
                    </div>
                </li>
                
                <li class="col5 box-figure">
                    <div class="box2">
                        <a href="/clearance/under-25.html"><img src="/media/menu/UNDER25_BLOCKv4 copy.png" alt=""><span>Under $25</span></a>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </li>
    
    <!--li class="new_nav_item5">
        <a href="/holidaze"><span class="has-submenu" style="color:#00A435;">Holidaze</span></a>
        <div class="submenu-wrapper">
            <div class="sub-box-wrap">
                <ul class="submenu">
                    <li class="col1">
                        <h3><a href="/lookz/christmas.html">Holidaze Shop</a></h3>
                        <ul>
                            <li><a href="/lookz/holiday-2016/clothing.html" >Clothing</a></li>
                            <li><a href="/lookz/holiday-2016/winter-cozy-shoes.html" >Shoes</a></li>
                            <li><a href="/lookz/holiday-2016/holiday-accessories.html" >Accessories</a></li>
                            <li><a href="/lookz/holiday-2016/beauty.html" >Beauty</a></li>
                        </ul>
                    </li>

                    <li class="col2">
                        <h3><a style="text-decoration:none !important; font-family:'proxima-nova-extra-condensed';">All I want 4 Xmas</a></h3>
                        <ul> 
                            <li><a href="/lookz/holiday-2016/stocking-stuffers.html">Stuff Ya Stocking</a></li>
                            <li><a href="/lookz/holiday-2016/christmas-holiday-lingerie.html">Santa Baby</a></li>
                            <li><a href="/lookz/party-dresses.html">New Years Eve</a></li>
                            <li><a href="/gift-certificate.html">Gift Cards</a></li>3
                        </ul>
                    </li>

                    <li class="col3 box-figure">
                        <div class="box1">
                            <a href="/lookz/holiday-2016/stocking-stuffers.html"><img src="/media/menu/STOCKING_BLOCKv2.png" alt=""><span>Stuff Ya Stocking</span></a>
                        </div>
                    </li>
                    <li class="col4 box-figure">
                        <div class="box2">
                            <a href="/lookz/holiday-2016/christmas-holiday-lingerie.html"><img src="/media/menu/SANTA_BABYv2.png" alt=""><span>Santa Baby</span></a>
                        </div>
                    </li>
                    <li class="col5 box-figure">
                        <div class="box2">
                            <a href="/lookz/party-dresses.html"><img src="/media/menu/NEWYEAR_BLOCKv2.png" alt=""><span>New Years Eve</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </li-->
</ul>


<style>
            
/*for search icon */
@media (min-width: 768px) {
    span.search_icon {
        float:left;
    }
    .search_icon i {
        width: 22px;
        height: 22px;
        box-sizing: border-box;
        position: relative;
        float:left;
    }
    .search_icon i img {
        width: 100%;
        height: auto;
    }
    .search_icon:hover {
        cursor: pointer;
    }
    .search_icon:hover img { 
        opacity: 0.7;
    }
    .top-search #search {
        border-bottom: 2px solid #fff !important;
    }

}
            
@media (min-width: 960px) {
    .search_icon::after {
        content: "";
        display: block;
        width: 120px;
        height:20px;
        border-bottom: 2px solid rgba(255,255,255,1.00);
        margin-left: 25px;
    }
    
    .like-search-form::after {
        content: "";
        display: block;
        width: 120px;
        border-bottom: 2px solid rgba(255,255,255,1.00);
        margin-right: -124px;
        height:18px;
        margin-left: 26px;
    }
    .like-search-form:hover::after {
        border-bottom: 2px solid rgba(255,255,255,0.7);                 
    }
    
    #nav-box .main-icons i img { float: left; }
    #nav-box .main-icons i.header-close-form { margin-right: 13px; }
    #nav-box .main-icons i { padding-right: 140px; }
    #nav-box .main-icons { margin-right: -6px }

}

@media (min-width: 768px) AND (max-width: 959px) {
    #nav-box .main-icons i { margin-right: 4px; }
}

@media (min-width:960px) {
    input#search {
        width: 88% !important;
    }
    
    div#top_search {
        width: 510px !important;
    }
    
    .search-button-aloglia {
        margin-right: 4px !important;
        margin-left: 6px;
    }
}

@media (min-width: 826px) AND (max-width: 959px) {
    input#search {
        width: 85% !important;
    }
    
    div#top_search {
        width: 380px !important;
    }
}

@media (min-width:768px ) AND (max-width:825px) {
    div#top_search {
        width: 380px !important;
    }
    
    input#search {width:85% !important;}
}

@media (min-width: 768px) {
    .side_lens_icon {
        float:left;
    }

    div#top_search {
        display: block;
        position: relative;
        margin-top: -34px !important;
    }

}

.search-button-aloglia {height:30px !important;}            
            


</style>
                    
<div class="top-search" id="top_search">
    <div id="algolia-searchbox">
        <button type="submit" class="search-button-aloglia"><img class="side_lens_icon" src="<?php echo $this->getSkinUrl('images/header/search_icon_02.svg') ?>" alt=""></button>
        <input type="search" name="search" id="search" class="input-text algolia-search-input" autocomplete="off" spellcheck="false" autocorrect="off" autocapitalize="off" placeholder="<?php //echo $placeholder; ?>" />
        <span class="main-icons">
            <i class="like-search-form" id="show_header_search" style="display: table; opacity: 1; z-index: 55;"><img src="<?php echo $this->getSkinUrl('images/header/search_icon_02.svg') ?>" id="header_lens_icon" alt=""></i>
            <i class="header-close-form" id="close_header_search" style="display: none; opacity: 0;"><img src="<?php echo $this->getSkinUrl('images/header/close_icon.svg') ?>" id="header_close_icon" alt=""></i>
        </span>
    </div>
</div>
                    
                    
<script type="text/javascript">
    document.onkeyup=function(e) {
        if(e.which == 13){
            $('search').blur();
            return false;
        }
    }
</script>
                    
<!-- new navigation --  end -->
