<!-- define bogo messaging -- start -->
<style>
	.bogo-msg span {color: #000000;}
</style>
<?php
	$bogo_msg_deskop_applied = "BOGO SALE &nbsp;<span>CONGRATS! YOUR DISCOUNT HAS BEEN APPLIED!</span>";
	$bogo_msg_mobile_applied = "BOGO SALE<br/> <span> YOUR DISCOUNT HAS BEEN APPLIED!";
	$bogo_msg_deskop_addmore = "BOGO SALE &nbsp;<span>ADD 1 MORE ITEM FOR YOUR 50% DISCOUNT.</span>";
	$bogo_msg_mobile_addmore = "BOGO SALE<br/><span>ADD 1 MORE ITEM FOR YOUR 50% DISCOUNT.";
	
?>
<!-- define bogo messaging -- end -->

<?php if (Mage::getStoreConfig('amrules/general/breakdown')){ ?>
    <?php $bogohtml = ""; ?>
    <?php $bogo_item_count = Mage::getSingleton('checkout/session')->getBogoPromoItem(); ?>
    <?php if($bogo_item_count){ ?>
        <?php $bogohtml .= '<div class="bogo-discount-box">'; ?>
        <?php if($bogo_item_count % 2 == 0){ ?>
            <?php $bogohtml .= '<span class="bogo-msg hidden-xs">'.$bogo_msg_deskop_applied.'</span>'; ?>
            <?php $bogohtml .= '<span class="bogo-msg  hidden-sm hidden-md hidden-lg">'.$bogo_msg_mobile_applied.'<span class="bogo-popup-view">View Details</span></span></span>'; ?>
        <?php }else{ ?>
            <?php $bogohtml .= '<span class="bogo-msg hidden-xs">'.$bogo_msg_deskop_addmore.'</span>'; ?>
            <?php $bogohtml .= '<span class="bogo-msg hidden-sm hidden-md hidden-lg">'.$bogo_msg_mobile_addmore.'<span class="bogo-popup-view">View Details</span></span></span>'; ?>
        <?php } ?>
        <?php $bogohtml .= '</div>'; ?>
        <div class="bogo-popup-details" style="display:none;">
            <img src="<?php echo $this->getSkinUrl('images/close_black.svg') ?>" alt="X" class="affirm-popup-close bogo-close" />
            <img src="/skin/frontend/dollskill/dollskill/images/FRI_13_BOGO_MOBILE_POPUP.jpg" hidefocus="true">
        </div>
    <?php } ?>
    <?php Mage::getSingleton('checkout/session')->unsBogoPromoItem(); ?>
    <style>

        .bogo-discount-box{
            position: relative;
            left: 0px;
            bottom: 0px;
            height: 50px;
            width: 100%;
            background: transparent;
            background-image: url("/skin/frontend/dollskill/dollskill/images/1-10-12-bogoBOGO_CART_SKINNY.jpg");
            font-family: 'proxima-nova', sans-serif;
            font-weight: bold;
            font-size: 27px;
            padding: 20px 0;
            text-align: center;
            color: #ff0000;
        }
        /* IE 6 */
        * html .bogo-discount-box {
            position:absolute;
            top:expression((0-(bogo-discount-box.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
        }
        .bogo-popup-close {
            float: right;
            z-index: 201;
            width: 20px;
            height: 20px;
            cursor: pointer;
            -webkit-filter: invert(100%);
            -moz-filter: invert (100%);
            -ms-filter: invert (100%);
            filter: invert(100%);
            margin: -5px 11px;
        }
        @media (max-width: 768px) {
            .bogo-discount-box{
                height: 55px;
                font-size: 14px;
                padding: 7px 0;
                text-align: center;
                float: left;
                line-height: 21px;
            }

            .bogo-popup-close {
                width:16px;
                margin: -15px 4px;
            }
        }
        @media (max-width: 320px) {
            .bogo-discount-box{
                font-size: 11px;
            }
        }
        @media (max-width: 360px) {
            .bogo-popup-details {
                width:90%;
                left: 5% !important;
            }
        }
        @media only screen and (min-width: 768px) and (max-width: 980px) {
            .bogo-discount-box{
                height: 55px;
                font-size: 24px;
                padding: 20px 0;
                text-align: center;
                float: left;
            }

            .bogo-popup-close {
                width:16px;
                margin: -15px 4px;
            }
        }
        .bogo-popup-view{
            font-size: 10px;
            margin-left: 4px;
            cursor:pointer;
        }
        .bogo-popup-view:hover{
            text-decoration:underline;
        }
        .bogo-popup-details {
            padding: 0px;
            font-weight: normal;
            z-index: 200;
            position: absolute;
            left: 10%;
        }
        .bogo-close{
            position: absolute;
            left: 90%;
        }
    </style>
    <script>
        jQuery(".wrapper").after('<?php echo $bogohtml; ?>');
        jQuery(document).ready(function() {
            function checkOffset() {
                if(jQuery('.bogo-discount-box').offset().top + jQuery('.bogo-discount-box').height() >= jQuery('#main_footer').offset().top - 1)
                    jQuery('.bogo-discount-box').css('position', 'relative');
                if(jQuery(document).scrollTop() + window.innerHeight < jQuery('#main_footer').offset().top)
                    jQuery('.bogo-discount-box').css('position', 'fixed'); // restore when you scroll up
            }
            jQuery(document).scroll(function() {
                if(jQuery('.bogo-discount-box').offset()){
                    checkOffset();
                }
            });
            if(jQuery('.bogo-discount-box').offset()){
				checkOffset();
			}
            jQuery('.bogo-popup-close').click(function(){
                jQuery('.bogo-discount-box').hide();
            });
        });
        function bogo_popup_details(){
            jQuery(".bogo-close").on('click', function(){
                jQuery(".bogo-popup-details").fadeOut(0);
            })
            jQuery(".bogo-popup-view").on('click', function(){
                jQuery("html, body").animate({
                    scrollTop: 0
                }, 400);
                jQuery(".bogo-popup-details").fadeIn(0);
            });
        }
        jQuery(document).ready(function(){
            bogo_popup_details();
        });
    </script>
<?php } ?>
