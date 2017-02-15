
<style>
@media only screen and (min-width: 768px) {
	.product-image__size-selector {
		width: 97%;
		position: absolute;
		bottom: 51px;
		display: inline-table;
		opacity: 0.8;
		display:none;
		-ms-transition: all 0.2s ease-in-out;
		-o-transition: all 0.2s ease-in-out;
		-moz-transition: all 0.2s ease-in-out;
		-webkit-transition: all 0.2s ease-in-out;
		transition: all 0.2s ease-in-out;
	}

	.size-selector__size-group {
		opacity:0;
		-ms-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-webkit-transition: all 0.5s ease-in-out;
		transition: all 0.5s ease-in-out;
	}

	.size-selector {
		font-size: 12px;
		line-height: 19.416px;
		font-weight: normal;
		font-family: 'graphik', 'Helvetica Neue', 'Helvetica Neue LT STD', 'Helvetica', 'Helvetica LT STD', 'Arial', 'sans-serif';
		background: #fff;
		padding: 7px;
		box-sizing: border-box;
		min-height: 39px;
		overflow: hidden;
	}

	.size-selector__size-container {
		overflow: hidden;
		height: 0px;
		text-align: center;
		-ms-transition: all 0.2s ease-in-out;
		-o-transition: all 0.2s ease-in-out;
		-moz-transition: all 0.2s ease-in-out;
		-webkit-transition: all 0.2s ease-in-out;
		transition: all 0.2s ease-in-out;
	}

	.size-slector-arrow {
		height: 9px;
		background:#FFFFFF url("<?php echo $this->getSkinUrl('images/arrow_up.svg') ?>") no-repeat;
		background-position-x: 50%;
	}

	.size-slector-arrow:hover {
		cursor:pointer;
	}

	li.size-selector__size {
		text-align: center;
		position: relative;
		color: #808284;
		display: inline-block;
		overflow: inherit !important;
		padding:0 !important;
		height:27px;
	}

	.size_outofstock {
		color: #a6a6a6 !important;
	}

	button.size-selector__link {
		background: transparent;
		border: 0;
		cursor: pointer;
		color: inherit;
		display: inherit;
		padding: 13px 12px;
		min-width: 39px;
	}

	button.size-selector__link:hover {
		color: #EE008A !important;
	}
	
	button.size-selector__link:active {
		background-color:transparent !important;
	}

	button.size_outofstock {
		cursor:default;
	}

	button.size_outofstock:hover {
		color: #a6a6a6 !important;
	}

	button.size_outofstock.disabled, .size_outofstock[disabled] {
		cursor: not-allowed;
		opacity: 0.65;
		filter: alpha(opacity=65);
		box-shadow: none;
	}

	.size-selected {
		color: #EE008A !important;
	}
	
	.category-listing.product-view li.product-item:hover .product-image__size-selector {display:inline-table;}

	.checkout-cart-index .size-selector__size-container, .checkout-cart-index .size-selector, .checkout-cart-index .size-slector-arrow {display: none !important;}

	.gomage-checkout-onepage-index .size-selector__size-container, .gomage-checkout-onepage-index .size-selector, .gomage-checkout-onepage-index .size-slector-arrow {display: none !important;}
	
	.catalog-category-view .product-image__size-selector, #category_grid_container .product-image__size-selector {margin-bottom: -9px;}
	
	.catalog-category-view .size-selector, #category_grid_container .size-selector {min-height: 36px;}
	
	/*to fix product with color swatch position*/
	#category_grid_container .swatches-list {position: absolute;}
	#resultdiv .swatches-list {position: absolute;}
	.category-listing.product-view li.product-item {margin-bottom:40px;}
	body.wishlist-index-index .swatches-list {position:absolute;}
	body.wishlist-index-index .category-listing.product-view li.product-item {margin-bottom:80px}
	
	
	/* for size rows setting */
	li.size-selector__size {clear:both}
	.linePosFirst.linePosLast {float: none;}
}
	
@media only screen and (max-width: 767px) {
	.product-image__size-selector {
		display: none !important;
		opacity: 0 !important;
	}
}
</style>

<script>


jQuery(document).ready(function(){

	jQuery('body').on('mouseover touchstart', '.product-image__size-selector', function (e) {


		// var curId = jQuery(this).attr('id').split("_");

		// console.log(curId[4] + '_' + curId[5] + ',' + addToCartLatest);
		/*
		 if(curId[4] + '_' + curId[5] !== addToCartLatest){
		 addToCartDelay = true;
		 }
		 */
		jQuery(".product-image__size-selector").css({
			'bottom': '62px'
		});

		jQuery(".size-selector__size-container").css({
			'height': '30%',
			'margin-bottom': '10px'
		});

		jQuery(".size-selector__size-group").css({
			'-ms-transition': 'all 0.3s ease-in-out',
			'-o-transition': 'all 0.3s ease-in-out',
			'-moz-transition': 'all 0.3s ease-in-out',
			'-webkit-transition': 'all 0.3s ease-in-out',
			'transition': 'all 0.3s ease-in-out',
			'opacity': 1.0
		});
	});

	jQuery('body').on('mouseout touchend', '.product-image__size-selector', function (e) {

		jQuery(".product-image__size-selector").css({
			'bottom': '51px'
		});

		jQuery(".size-selector__size-group").css({
			'-ms-transition': 'all 0.1s ease-in-out',
			'-o-transition': 'all 0.1s ease-in-out',
			'-moz-transition': 'all 0.1s ease-in-out',
			'-webkit-transition': 'all 0.1s ease-in-out',
			'transition': 'all 0.1s ease-in-out',
			'opacity': 0
		});

		jQuery(".size-selector__size-container").css({
			'-ms-transition': 'all 0.1s ease-in-out',
			'-o-transition': 'all 0.1s ease-in-out',
			'-moz-transition': 'all 0.1s ease-in-out',
			'-webkit-transition': 'all 0.1s ease-in-out',
			'transition': 'all 0.1s ease-in-out',
			'height': '0px',
			'margin-bottom': '0px'
		});

	});

	jQuery(".size-selector__size-container").css('display', 'none !important;');
});
</script>
