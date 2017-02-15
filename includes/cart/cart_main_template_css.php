<script type="text/javascript">
!function(a){var b=function(a,b){var c=a.css("padding-"+b);return c?+c.substring(0,c.length-2):0},c=function(a){var c=b(a,"left"),d=b(a,"right");return a.width()+c+d+"px"},d=function(b,c){var d={width:250,push:!0,position:"left",speed:300,trigger:void 0,autoEscape:!0,show:function(){},shown:function(){},hidden:function(){},hide:function(){},top:0,overlay:!1,zIndex:1049,overlayColor:"rgba(0,0,0,0.5)"};this.setting=a.extend(d,c),this.element=b,this.init()};a.extend(d.prototype,{init:function(){var b=this,d=this.setting,e=this.element,f="all ease "+d.speed+"ms";e.css({position:"fixed",width:d.width,transition:f,height:"100%",top:d.top}).css(d.position,"-"+c(e)),d.overlay&&(e.css("z-index",d.zIndex),b.overlayElement=a("<div class='slide-reveal-overlay'></div>").hide().css({position:"fixed",top:0,left:0,height:"100%",width:"100%","z-index":d.zIndex-1,"background-color":d.overlayColor}).click(function(){b.hide()}),a("body").prepend(b.overlayElement)),e.data("slide-reveal",!1),d.push&&a("body").css({position:"relative","overflow-x":"hidden",transition:f,left:"0px"}),d.trigger&&d.trigger.length>0&&d.trigger.on("click.slideReveal",function(){e.data("slide-reveal")?b.hide():b.show()}),d.autoEscape&&a(document).on("keydown.slideReveal",function(c){0===a("input:focus, textarea:focus").length&&27===c.keyCode&&e.data("slide-reveal")&&b.hide()})},show:function(b){var d=this.setting,e=this.element,f=this.overlayElement;(void 0===b||b)&&d.show(e),d.overlay&&f.show(),e.css(d.position,"0px"),d.push&&("left"===d.position?a("body").css("left",c(e)):a("body").css("left","-"+c(e))),e.data("slide-reveal",!0),(void 0===b||b)&&setTimeout(function(){d.shown(e)},d.speed)},hide:function(b){var d=this.setting,e=this.element,f=this.overlayElement;(void 0===b||b)&&d.hide(e),d.push&&a("body").css("left","0px"),e.css(d.position,"-"+c(e)),e.data("slide-reveal",!1),(void 0===b||b)&&setTimeout(function(){d.overlay&&f.hide(),d.hidden(e)},d.speed)},toggle:function(a){var b=this.element;b.data("slide-reveal")?this.hide(a):this.show(a)},remove:function(){this.element.removeData("slide-reveal-model"),this.setting.trigger&&this.setting.trigger.length>0&&this.setting.trigger.off(".slideReveal"),this.overlayElement&&this.overlayElement.length>0&&this.overlayElement.remove()}}),a.fn.slideReveal=function(b,c){return void 0!==b&&"string"==typeof b?this.each(function(){var d=a(this).data("slide-reveal-model");"show"===b?d.show(c):"hide"===b?d.hide(c):"toggle"===b&&d.toggle(c)}):this.each(function(){a(this).data("slide-reveal-model")&&a(this).data("slide-reveal-model").remove(),a(this).data("slide-reveal-model",new d(a(this),b))}),this}}(jQuery);
</script>

<style type="text/css">

	.slider{
		background-color: white;
		color: black;
		overflow-y: auto;
	}
	@media (min-width: 320px) AND (max-width: 440px) {
		.slider {
			width: 100% !important;
		}
	}
	#trigger{
		/*width: 10%;
		padding: 10px;
		margin: 5px 5%;*/
		float: right;
		/*top: -1.4vw;
		left: -5vw;*/
		position: relative;
		z-index: 120;
		/*opacity: 0;*/
		
		background-repeat: no-repeat;
		background-image: url('media/new_cart_assets/cart_white.svg');
		background-size: 55%;
		background-color: transparent;
		display: inline-block;
		padding: 0px 22px;
		height: 26px;
		width: initial;
		margin-right: 70px;
		margin-top: -20px;
	}
	
	@media (min-width: 768px) AND (max-width: 1115px) {
		#trigger {
			margin-top:0px;
		}
	}
	
	@media (min-width: 480px) AND (max-width: 767px) {
		#trigger {
			margin-right: 24vw;
			margin-top: -24.33vw;
			width: 10%;
			height: 7vw;
			background-size: 10vw 7vw;
		}
	}
	
	@media (min-width: 320px) AND (max-width: 479px) {
		#trigger {
			margin-right: 24vw;
			margin-top: -26.55vw;
			width: 10%;
			height: 7vw;
			background-size: 10vw 7vw;
		}
	}
	
	
	
	@media (min-width: 768px) {
		.cart_wrapper {
			/*min-height: 550px;*/
			min-height: 565px;
			overflow: auto;
			position: relative;
			height: 100vh;
		}
	}
	@media (min-width: 320px) AND (max-width: 767px) {
		.cart_wrapper {

		}
	}

	.cart_wrapper img {
		display: inline;
		vertical-align: inherit;
	}
	

	/**** - CART HEADER SECTION  - start *******************************************************/
	/*-----------------------------------------------------------------------------------------*/	
	
	.cart_header {
		background-color:black;
		height: 50px;
		position: relative;
	}
	.cart_header .cart_top_title {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 14.5px;
		text-transform:uppercase;
		font-weight: 500;
		color: white;
		padding: 10px 14px;
		/*text-align: center;*/
	}
	.cart_header .cart_top_title span {
		margin-left:112px;
		vertical-align: super;
	}
	.cart_header .cart_top_title .cart_arrow_black:hover {
		cursor: pointer;
		opacity: 0.6;
	}
	
	/**** - CART HEADER SECTION  - end *********************************************************/
	/*-----------------------------------------------------------------------------------------*/
	
	
	
	
	/**** - CART MIDDLE SECTION  - start *******************************************************/
	/*-----------------------------------------------------------------------------------------*/
	
	.cart_middle {
		background-color: white;
		padding: 20px 14px 20px 19px;
		overflow-y: auto;
		/*max-height: 30vh;
		height: 50%;*/
		
		min-height: 120px;
		
		position: relative;

	}
	@media (min-width: 768px) {
		.cart_middle {
			max-height: 64.55vh;
			
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;
			display: flex;
			
			-webkit-backface-visibility: hidden;
			backface-visibility: hidden;
			will-change: overflow;
			
			/*height: calc(90.33vh - 3.13rem - 16.63rem);*/
			height: calc(92.55vh - 8.88rem - 14.66rem);
		}
	}
	@media (min-width: 320px) AND (max-width: 767px) {
		.cart_middle {
			max-height: 100%;
			padding: 20px 3vw 20px 2vw;
		}
	}
	.cart_middle ul {
		list-style-type: none;
        width: 100%;
	}
	.cart_middle li {
		border-bottom: 1px solid #ededed;
		padding-bottom: 10px;
		padding-top: 10px;
	}
	
	.cart_middle .product-info_section {
		display: block;
		/*position: relative;*/
		position: static;
		float: left;
		margin-bottom: 10px;
		max-width: 390px;
		width: 100%;
	}
	.cart_middle .product-info_section a.product-delete {
		position: absolute;
		display: block;
		right: 0px;
		margin-right: 14px;
	}
	.cart_middle .product-info_section .product-image {
		float:left;
		margin-right: 25px;
	}
	.cart_middle .product-info_section .product-info_details {
		/*float: left;
		width: 300px;
		width: 287px;*/
		display: block;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	}
	@media (min-width: 320px) AND (max-width: 440px) {
		.cart_middle .product-info_section .product-info_details {
			/*width: 62vw;*/
		}
	}
	.product-info_details .product-name_section a {
		color: black;
		text-decoration: none;
		float: none;
	}
	.product-info_details .product-name_section a:hover .product_name {
		text-decoration: underline;
		-webkit-font-smoothing: antialiased;
	}
	.product-info_details .product-name_section .manufacture_name {
		font-size: 12px;
		color: #a5a5a5;
		display: block;
	}
	@media (min-width: 320px) AND (max-width: 440px) {
		.product-info_details .product-name_section .manufacture_name {
			font-size: 11px;
		}
	}
	.product-info_details .product-name_section .product_name {
		font-size: 14px;
		color: black;
		font-weight: 600;
		/*display: block;*/
	}
	.product-info_details .product-options-color-size {
		font-size: 11px;
		color: black;
		margin-top: 5px;
		margin-bottom: 10px;
	}
	.product-info_details .product-qty-price .price_original {
		font-size: 14px;
		font-weight: 600;
		margin-left: 6px;
	}
	@media (min-width: 320px) AND (max-width: 440px) {
		.product-info_details .product-qty-price .price_original {
			font-size: 12px;
		}
	}
	.product-info_details .product-qty-price .price_original.crossed {
		text-decoration:line-through;
	}
	.product-info_details .product-qty-price .price_sale {
		font-size: 14px;
		font-weight: 600;
		color: red;
		margin-left: 6px;
	}
	@media (min-width: 320px) AND (max-width: 440px) {
		.product-info_details .product-qty-price .price_sale {
			font-size: 12px;
		}
	}
	.product-info_details .product-qty-price .price_sale.crossed {
		text-decoration:line-through;
	}
	.product-info_details .product-qty-price {
		margin-bottom: 10px;
	}
	.product-info_details .product-wishlist {
		font-size: 11px;
        float: left;
	}
	.product-info_details .product-wishlist a {
		text-decoration: none;
		color: black;
	}
	.product-info_details .product-wishlist a:hover {
		text-decoration: none;
		color:#3F3F3F;
	}
	.product-info_details .product-wishlist span {
		margin-left: 10px;
		vertical-align:text-bottom;
	}
	.product-info_details .product-wishlist img {
		display: inline;
		vertical-align: inherit;
	}
	.product-qty-price select.size_custom_dropdown {
		-webkit-appearance: none;
		-moz-appearance: none;
		border: 0 !important;
		background-color: #eeeeee;
		color: black;
		-webkit-border-radius: 5px;
		border-radius: 0px;
		font-size: 12px;
		padding: 6px;
		width: 15%;
		cursor: pointer;
		background: #eeeeee url(media/new_cart_assets/arrow_black_select.png) no-repeat 94% 50%;
		background-size: 33% 25%;
	}
	.product-qty-price select.size_custom_dropdown:focus {
		border-color: #999999;
		outline: none;
	}
	.product-qty-price .custom_scrollable {
		height: auto;
		max-height: 100px;
		overflow-x: hidden;
	}
	
	

	/**** - CART MIDDLE SECTION  - end *********************************************************/
	/*-----------------------------------------------------------------------------------------*/
	
	
	
	
	/**** - CART FOOTER SECTION  - start *******************************************************/
	/*-----------------------------------------------------------------------------------------*/
	.cart_footer {
		background-color:#eeeeee;
		min-height:347px;
		width: 440px;
		bottom: 0px;
		position: absolute;
	}
	@media (min-width: 320px) AND (max-width: 767px) {
		.cart_footer {
			bottom: initial;
			width: 100%;
		}
	}
	.cart_footer .content {
		margin: 24px 16px 24px 15px;
		/*background-color:#822E30;*/
		width: 409px;
		height: 299px;
	}
	@media (min-width: 320px) AND (max-width: 767px) {
		.cart_footer .content {
			width: 93%;
		}
	}
	.cart_footer .content img {
		margin-bottom: 6px;
	}
	.cart_footer .content img:hover {
		cursor: pointer;
		opacity: 0.6;
	}
	.cart_footer .content ul {
		list-style-type:none;
	}
	.cart_footer .content ul li {
		margin-bottom: 11px;
	}
	.cart_footer .content .subtotal_title, .cart_footer .content .shipping_title {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 12.5px;
		float:left;
		clear: left;
    	margin-bottom: 11px;
	}
	.cart_footer .content .shipping_title_info {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 11.5px;
		float:left;
		clear: left;
    	margin-bottom: 11px;
		color: #999999;
		margin-top:-9px;
	}
	.cart_footer .content .shipping_title_info price {
		color: black;
	}
	.cart_footer .content .subtotal_price, .cart_footer .content .shipping_price {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 12.5px;
		float:right;
	}
	.cart_footer .content .total_title {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 15.5px;
		font-weight: 500;
		float:left;
		clear: left;
    	margin-bottom: 22px;
	}
	.cart_footer .content .total_price {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 15.5px;
		font-weight: 500;
		float:right;
	}
	.cart_footer .content .cart_arrow_shipping_black {
		margin-bottom: -1px;
		margin-left: 18px;
	}
	.cart_footer .content #shipping_title_top:hover {
		cursor: pointer;
	}
	.cart_footer .content .cart_arrow_shipping_black:hover {
		cursor: pointer;
	}
	.shipping_extra_info_section {
		display: none;
	}
	.cart_footer .content .shipping_extra_info {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 12.5px;
		clear: left;
    	margin-bottom: 11px;
	}
	/*.shipping_extra_info select:not([title="Results per page"]) {*/
	.shipping_extra_info select {
		width: 100%;
		margin-bottom: 8px;
		background: #fff url(media/new_cart_assets/arrow_black_select.png) no-repeat 100% 50%;
		padding: 5px;
		height: 34px;
		box-sizing: border-box;
		-webkit-appearance: none;
		-moz-appearance: none;
		text-indent: 0.01px;
		border-radius: 0;
		border: 1px solid #ccc;
		font-size: 13px;
		text-transform: none;
		background-size: inherit !important;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	}
	/*.shipping_extra_info select:not([title="Results per page"]):focus {*/
	.shipping_extra_info select:focus {
		border-color: #999999;
		outline: none;
	}
	.shipping_extra_info_section label {
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 12.5px;
		/*float:left;*/
		clear: left;
    	margin-bottom: 11px;
		z-index: 9;
		font-weight: normal;
		
		/* add the following to fix the issue when click on radio button that wasn't change the selection */
		display: block;
		position: absolute;
		padding-left: 30px;
		padding-bottom: 5px;
		margin-top: 3px;

	}
	.shipping_extra_info_section label:hover {
		cursor: pointer;
	}
	.shipping_extra_info_section input[type=radio] {
		visibility:hidden;
		/* add the following to fix the issue when click on radio button that wasn't change the selection */
		position: absolute;
	}
	.shipping_extra_info_section li .shipping_method_checkbox {
		display: block;
		/*position: absolute;*/
		border: 2px solid #000000;
		border-radius: 100%;
		height: 15px;
		width: 15px;
		/*top: 30px;
		left: 20px;*/
		z-index: 5; 
		transition: border .25s linear;
		-webkit-transition: border .25s linear;
		/* remove the following to fix the issue when click on radio button that wasn't change the selection
		float: left;*/
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	.shipping_extra_info_section li:hover .shipping_method_checkbox {
		/*border: 5px solid #FFFFFF;*/
		cursor: pointer;
	}
	.shipping_extra_info_section li .shipping_method_checkbox::before {
		display: block;
		/*position: absolute;*/
		content: '';
		border-radius: 100%;
		height: 15px;
		width: 15px;
		top: 5px;
		left: 5px;
		margin: auto;
		transition: background 0.25s linear;
		-webkit-transition: background 0.25s linear;
	}
	input[type=radio]:checked ~ .shipping_method_checkbox {
		/*border: 5px solid #0DFF92;*/
	}
	input[type=radio]:checked ~ .shipping_method_checkbox::before{
		/*background: #0DFF92;*/
		background: black;
	}
	input[type=radio]:checked ~ label{
		/*color: #0DFF92;*/
	}
	
	
	/**** - Section Credit Store / Gift card  - start ***/
	.section_credit_store {
		margin-top: 11px;
		text-align: center;
		color: #f1018a;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 13.5px;
		font-weight: 500;
	}
	.section_credit_store:hover {
		cursor: pointer;
		text-decoration:underline;
		
	}
	.promo_store_credit_section {
		display:none;
		margin-top: 15px;
	}
	.promo_store_credit_section .field-wrapper{
		position: relative;
		clear: both;
		margin: 9px 0 0 0;
	}
	.promo_store_credit_section .input-text {
		border-radius: 0;
		height: 35px;
		margin: 0;
		padding: 0 80px 0 10px;
		width: 77.55%;
		color: #000;
		font-weight: normal;
		font-size: 13px;
		/*font-family: proxima-nova, Arial, sans-serif; */
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		border: 1px solid #8d8d8d;
	}
	.promo_store_credit_section .input-text:focus {
		outline: none;
	}
	.promo_store_credit_section .button-wrapper {
		position: absolute;
		right: 0;
		top: 0;
	}
	.promo_store_credit_section .button-wrapper > button {
    	float: left;
	}
	.promo_store_credit_section button.button2 {
		overflow: hidden;
		width: 72px;
		height: 36px;
		margin: 0;
		background: #000;
		cursor: pointer;
		border: 0;
	}
	.promo_store_credit_section button.button2 span {
		background: #000;
		border: 0;
		color: #fff;
		font-size: 15px;
		line-height: 36px;
		width: 60px;
		overflow: hidden;
		/*font-family: bebas-neue, Arial, sans-serif;*/
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		height: 30px;
		text-decoration: none;
		text-transform: uppercase;
		display: inline-block;
		font-weight: normal;
	}
	.promo_store_credit_section .credit_store_display span {
		margin-top: 11px;
		text-align: center;
		color: black;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 13.5px;
		font-weight: 500;
	}
	.promo_store_credit_section .credit_store_display_checkbox input[type=checkbox] {
		visibility:hidden;
	}
	.promo_store_credit_section .credit_store_display_checkbox {
		/*width: 20px;
		margin: 20px auto;*/
		position: relative;
		float: left;
		margin-right: 15px;
	}
	.promo_store_credit_section .credit_store_display_checkbox label {
		width: 18px;
		height: 18px;
		cursor: pointer;
		position: absolute;
		top: 0;
		left: 0;
		background: -webkit-linear-gradient(top, #222222 0%, #45484d 100%);
		background: linear-gradient(to bottom, #222222 0%, #45484d 100%);
		/*border-radius: 4px;*/
		box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px rgba(255, 255, 255, 0.4);
		max-width: none;
	}
	.promo_store_credit_section .credit_store_display_checkbox label:after {
		content: '';
		width: 9px;
		height: 5px;
		position: absolute;
		top: 3px;
		left: 3px;
		border: 2px solid #fcfff4;
		border-top: none;
		border-right: none;
		background: transparent;
		opacity: 0;
		-webkit-transform: rotate(-45deg);
		transform: rotate(-45deg);
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	.promo_store_credit_section .credit_store_display_checkbox label:hover::after {
		/*opacity: 0.3;*/
	}
	.promo_store_credit_section .credit_store_display_checkbox input[type=checkbox]:checked + label:after {
		opacity: 1;
	}
	/**** - Section Credit Store / Gift card  - end ***/
	
	/**** - CART FOOTER SECTION  - end *********************************************************/
	/*-----------------------------------------------------------------------------------------*/
</style>
