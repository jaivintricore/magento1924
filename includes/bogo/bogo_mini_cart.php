<div>
<?php if (Mage::getStoreConfig('amrules/general/breakdown') && $countItems){ ?>
	<?php $bogo_item_count = Mage::getSingleton('checkout/session')->getBogoPromoItem(); ?>
		<?php if($bogo_item_count){ ?>
			<?php if($bogo_item_count % 2 == 0){ ?>
				<div class="bogo-discount-box-minicart-even">
					<span>BOGO SALE</span><br/>
					<span style="font-size: 13px;text-align: center;width: 100%;float: left; color:#000000;">YOUR DISCOUNT HAS BEEN APPLIED!</span>
				</div>	
			<?php }else{ ?>
				<div class="bogo-discount-box-minicart-odd">
					<span>BOGO SALE</span><br/>
					<span style="font-size: 13px;text-align: center;width: 100%;float: left; color:#000000;">ADD 1 MORE ITEM FOR YOUR 50% DISCOUNT</span>
				</div>	
			<?php } ?>
		<?php } ?>
<style>
	.bogo-discount-box-minicart-odd {
		left: 0px;
		bottom: 0px;
		height: 55px;
		width: 100%;
		background: #fa146c;
		background-image: url("/skin/frontend/dollskill/dollskill/images/1-10-12-bogoMINI_CART_BANNER.jpg");
		font-family:'proxima-nova',sans-serif;
		font-size: 13px;
		padding: 10px 0;
		text-align: center;
		font-weight: bold;
		color: #ff0000;
		line-height: 15px;
	}
	.bogo-discount-box-minicart-even {
		left: 0px;
		bottom: 0px;
		height: 55px;
		width: 100%;
		background: #fa146c;
		background-image: url("/skin/frontend/dollskill/dollskill/images/1-10-12-bogoMINI_CART_BANNER.jpg");
		font-family:'proxima-nova',sans-serif;
		font-size: 13px;
		padding: 10px 0;
		text-align: center;
		font-weight: bold;
		color: #ff0000;
		line-height: 15px;
	}
	/* IE 6 */
	* html .bogo-discount-box-minicart-odd {
	   position:absolute;
	   top:expression((0-(bogo-discount-box.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
	}
	* html .bogo-discount-box-minicart-even {
	   position:absolute;
	   top:expression((0-(bogo-discount-box.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
	}
	</style>
	<?php Mage::getSingleton('checkout/session')->unsBogoPromoItem(); ?>
<?php } ?>
</div>