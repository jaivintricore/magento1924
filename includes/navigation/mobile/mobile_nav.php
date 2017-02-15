<!-- for mobile navigation - css - start -->
<style>
	@media (max-width:767px) {
		.new_mobile_nav {
			display:initial;
			margin: 10px 0 !important;
		}
		.submenu-wrapper .sub-box-wrap{
			padding:0;
		}
		.submenu-wrapper ul li{
			max-width:100% !important;
			float:left;
			width:100%;
			padding:0;
			border-bottom:1px solid #fff;
			position:relative;
		}
		.submenu-wrapper ul li a:hover{
			text-decoration:none !important;
		}
		.submenu-wrapper ul li:not([style*="display: none"]):last-child{
			border:none;
		}
		.submenu-wrapper ul li li{
			border:none;
			background:#ccc;
			border-bottom: 1px solid #fff;
		}
		.submenu-wrapper ul li li a{
			color:#000;
			font-size:5.3vw;
			padding:12px 14px;
			width:100%;
			display:block;
			text-transform:uppercase;
			font-family: 'proxima-nova-sc-osf-ext-cond', Arial, 'BebasRegular', sans-serif;
		}
		.submenu-wrapper ul li ul{
			display:none;
		}
		.submenu-wrapper ul li h3{
			font-size:18px;
			height:45px;
			width:100%;
			float:left; 
			line-height:45px;
			padding:0 10px;
			margin:0;
			background: #262626 url("<?php echo $this->getSkinUrl('images/arrow_down_white.svg') ?>") no-repeat 96.5% 50%;
			background-size: 19px 11px;
		}
		.submenu-wrapper ul li h3 a{
			width:100%;
			float:left;
			clear:none;
			text-decoration:none;
			font: 6vw/45px 'proxima-nova-sc-osf-ext-cond', Arial, 'BebasRegular', sans-serif;
		}
		.submenu-wrapper ul li h3.activeM{
			background: #262626 url("<?php echo $this->getSkinUrl('images/arrow_minus_white.svg') ?>") no-repeat 96.5% 50%;
		}
		.submenu-wrapper ul li ul.activeM{
			display:block;
			background:#ccc;
		}
	
		.new_top_nav {
			margin:0;
			padding:0;
			position:relative;
			width:100%;
			z-index:200;
		}
		.new_top_nav li {
			padding:5px 12px;
		}

		.new_top_nav li.new_nav_item1, .new_top_nav li.new_nav_item2, .new_top_nav li.new_nav_item4  {
			padding: 1.9vw 3.3vw 3.9vw 3.3vw;
			margin: -2vw 4vw 0 -3vw;
		}
		
		li.new_nav_item1:hover .has-submenu, li.new_nav_item2:hover .has-submenu, li.new_nav_item3:hover .has-submenu, li.new_nav_item4:hover .has-submenu, li.new_nav_item5:hover .has-submenu { 
			padding: 0;
		}
		
		.new_top_nav li.new_nav_item1 span, .new_top_nav li.new_nav_item2 span, .new_top_nav li.new_nav_item4 span {
			font-size: 6.5vw;
		}
		
		.submenu-wrapper {
		}
		
		#nav-box {
			padding-top: 1.8vw !important;
		}
		
		#submenu1, #submenu2, #submenu4 {
			position:static;
			float:left;
			display:none;
			z-index:10;
			height:auto;
		}
		
		#top_search {
			float: left;
    			position: absolute;
			margin-top: 0.44vw !important;
		}
		
		li.new_nav_item1:hover, li.new_nav_item2:hover, li.new_nav_item3:hover, li.new_nav_item4:hover, li.new_nav_item5:hover { 
			background-color: transparent;
			cursor: pointer; 
		}
		.new_nav_item1, .new_nav_item2, .new_nav_item3, .new_nav_item4, .new_nav_item5 { 
			background-color: transparent; 
		}
		.new_nav_item1.clicked, .new_nav_item2.clicked, .new_nav_item3.clicked, .new_nav_item4.clicked, .new_nav_item5.clicked { 
			background-color: #262626 !important; 
		}
		
		ul.activeM li.hover_effect {background:#969696};
		
		.hover_effect {background:#969696;}
		
		.submenu-wrapper ul li.col5 {display:block;}
		
		p.new_nav_sub {
			height: 45px;
			width: 100%;
			float: left;
			line-height: 45px;
			padding: 0 10px;
			margin: 0;
			background: #262626;
			font: 6vw/45px 'proxima-nova-sc-osf-ext-cond', Arial, 'BebasRegular', sans-serif;
			text-transform: uppercase;
		}
		
		.new_top_nav a {
			display: block;
			width: 100%;
		}
		
		p.new_nav_sub.hover_effect_menu {background-color: #565656;}
		
	}
</style>

<!-- for mobile navigation - css - end -->

<ul class="new_top_nav new_mobile_nav" style="display:block;">
    <li class="new_nav_item1">
        <span class="has-submenu">What's New</span>
    </li>
    
    <li class="new_nav_item2">
        <span class="has-submenu">Shop</span>
    </li>
    
    <li class="new_nav_item4">
        <span class="has-submenu" style="color:#ff0000;">Clearance</span>        
    </li>
</ul>
