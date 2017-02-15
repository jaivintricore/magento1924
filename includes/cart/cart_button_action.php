<!-- for new cart - button action -- start -->

<button id="trigger"></button>
    
<script type="text/javascript">
	
	var shipping_method_switcher = 0;
	
	jQuery(function(){
		slider1 = jQuery("#slider").slideReveal({
		  width: "440px",
		  push: false,
		  position: "right",
		  speed: 750,
		  trigger: jQuery("#trigger"),
		  // autoEscape: false,
		  overlay: true,
		  top: 0,
		  //overlayColor: 'rgba(255,255,255,0.5)'
		  //overlayColor: 'rgba(123,123,123,0.6)'
		  overlayColor: 'rgba(98,98,98,0.6)'
		}).css ({'display':'block'});
		
		
		jQuery("#cart_arrow_black").click (function() {
		  slider1.slideReveal("hide");
		});
		
		jQuery("#shipping_title_top").click (function() {
			
			if(shipping_method_switcher == 0) {
				jQuery(".shipping_extra_info_section").css({'display':'block'});
				shipping_method_switcher = 1;
				jQuery(".cart_footer").css({'min-height' : '432px'});
				jQuery(".cart_arrow_shipping_black").css({
					'-webkit-transform' : 'rotate(180deg)',
					'-moz-transform' : 'rotate(180deg)',
					'-ms-transform' : 'rotate(180deg)',
					'-o-transform' : 'rotate(180deg)',
					'transform' : 'rotate(180deg)',
					'margin-bottom' : '1px',
					'margin-left' : '10px'
				});
				jQuery(".cart_footer .content ").css ({'height' : 'auto'});
				jQuery(".section_credit_store").css({'display' : 'block'});
				jQuery(".promo_store_credit_section").css({'display' : 'none'});
			}
			else {
				jQuery(".shipping_extra_info_section").css({'display':'none'});
				jQuery(".cart_footer").css({'min-height' : '347px'});
				jQuery(".cart_arrow_shipping_black").css({
					'-webkit-transform' : 'rotate(0deg)',
					'-moz-transform' : 'rotate(0deg)',
					'-ms-transform' : 'rotate(0deg)',
					'-o-transform' : 'rotate(0deg)',
					'transform' : 'rotate(0deg)',
					'margin-bottom' : '-1px',
					'margin-left' : '18px'
				});
				jQuery(".cart_footer .content ").css ({'height' : '299px'});
				shipping_method_switcher = 0;
			}
		});
		
		jQuery(".section_credit_store").click(function () {
			jQuery(".cart_footer").css({'min-height' : '385px'});
			jQuery(".section_credit_store").css({'display' : 'none'});
			jQuery(".promo_store_credit_section").css({'display' : 'block'});
			jQuery(".cart_footer .content ").css ({'height' : 'auto'});
			
			jQuery(".shipping_extra_info_section").css({'display':'none'});
			jQuery(".cart_arrow_shipping_black").css({
				'-webkit-transform' : 'rotate(0deg)',
				'-moz-transform' : 'rotate(0deg)',
				'-ms-transform' : 'rotate(0deg)',
				'-o-transform' : 'rotate(0deg)',
				'transform' : 'rotate(0deg)',
				'margin-bottom' : '-1px',
				'margin-left' : '18px'
			});
			shipping_method_switcher = 0;
		});
		
	});


</script>

<!-- for new cart - button action -- end -->
