<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined("ABSPATH")) {
  exit(); // Exit if accessed directly
}
global $product;

wp_enqueue_style(
  "general",
  plugin_dir_url(__FILE__) . "public/css/sitecss.css",
  1.1,
  "all"
);
wp_enqueue_script(
  "configurator",
  "https://configurator.ione360.com/js/threedconfigurator-standalone.bundle.min.js",
  [],
  true
);
?>
<html>
<head>
	<meta charset="utf-8">
	<base href=".">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="images/favicon.png" rel="shortcut icon">
</head>
<div>
	<!--	adds the woocommerce message when a product has been added to the cart	 -->
			<?php do_action("woocommerce_before_single_product"); ?>
</div>
 <body>
	<div id="selections-expand">
		<div class="product-main-information">
			<div class="product-essential-wrapper">
				<div class="product-essential">
					<div class="configurator-image active threed" id="threedconfigurator">
					<div class="product-media">
						<div class="product-placeholder">
							<div class="animated-wrapper">
						<button class="animated_3d"	style="opacity: 1;">
							<span>back to 3D</span>
							<i class="fa fa-download"></i>
						</button>
						<button class="animated_2d" style="pointer-events: none; opacity: 0.2;">
							<i class="fa fa-download"></i>
							<span>watch in 2D</span>
						</button>
					</div>
							<div class="image-wrapper">
							<img id="render_img" src= "<?php echo esc_url(
         wp_get_attachment_url($product->get_image_id())
       ); ?>" />
								<img id="loading-gif" class="loading-gif" src="<?php echo esc_url(
          plugins_url("public/images/loading.gif", __FILE__)
        ); ?>" />
							<div class="animated-wrapper">
								<img id="animated_gif" src="" />
							</div>
							<button id="forcerender">
							<i class="fas fa-sync-alt"></i>
							</button>
							</div>
						</div>
						<div class="threed-viewer">
							<threed-configurator></threed-configurator>
					 </div>
					</div>
					<div class="product-info">
						<div class="selections">
							<div class="selections-header" id="selections-click">
								<p>Customize <?php echo esc_textarea($product->get_title()); ?> </p>
							</div>
							<threed-selections id=selector></threed-selections>
						</div>
						<div class="addtocart">
								<button	id="add-to-cart-modal" > Add to Cart </button>
							<div style="display: none;">
								<?php do_action("woocommerce_simple_add_to_cart", 30); ?>
							 </div>
							<!-- <button class="animated_3d_demo" type="button">
								<span> 2D / 3D </span>
							</button> -->
							<div class="added_to_cart"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		 </div>
	</div>
	<!-- 	this adds the description, review and similar products block at bottom of the product page -->
	<div class="summary entry-summary">
		  /**
 * Hook: woocommerce_single_product_summary.
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 * @hooked WC_Structured_Data::generate_product_data() - 60
 */<?php

do_action("woocommerce_after_single_product_summary"); ?>
	 </div>

	<script>
	/* iOne connection settings */
	<?php
 $configurator_url = esc_attr(get_option("configurator_endpoint_setting"));
 $configurator_schema = esc_attr(get_option("configurator_scheme_setting"));
 $configurator_version = esc_attr(get_option("configurator_version_setting"));
 $configurator_cdn = esc_attr(get_option("configurator_cdn_setting"));
 $configurator_assets = esc_attr(get_option("configurator_assets_setting"));
 $configurator_language = esc_attr(get_option("configurator_language_setting"));
 $configurator_standaloneARButton = esc_attr(
   get_option("configurator_standaloneARButton_setting")
 );
 $configurator_AREnabled = esc_attr(
   get_option("configurator_AREnabled_setting")
 );
 $configurator_standaloneFloors = esc_attr(
   get_option("configurator_standaloneFloors_setting")
 );
 $configurator_inlineAnswer = esc_attr(
   get_option("configurator_inlineAnswers_setting")
 );
 $configurator_showAsConfigured = esc_attr(
   get_option("configurator_showAsConfigured_setting")
 );
 $configurator_gtm = esc_attr(get_option("configurator_gtm_setting"));
 $configurator_vrEnabled = esc_attr(
   get_option("configurator_vrEnabled_setting")
 );
 $configurator_show3dwatermark = esc_attr(
   get_option("configurator_show3dwatermark_setting")
 );
 $configurator_showtagfilter = esc_attr(
   get_option("configurator_showtagfilter_setting")
 );
 $configurator_showzoombutton = esc_attr(
   get_option("configurator_showzoombutton_setting")
 );
 $configurator_showstockstatus = esc_attr(
   get_option("configurator_showstockstatus_setting")
 );
 $configurator_lightpresetsindex = esc_attr(
   get_option("configurator_lightpresetsindex_setting")
 );
 $configurator_timeoutinms = esc_attr(
   get_option("configurator_timeoutinms_setting")
 );
 $configurator_renderhost = esc_attr(
   get_option("configurator_render_host_setting")
 );
 $configurator_renderport = esc_attr(
   get_option("configurator_render_port_setting")
 );
 $configurator_rendermode = esc_attr(get_option("configurator_rendermode"));
 $configurator_camerarotationX = esc_attr(
   get_option("configurator_render_camRotationX")
 );
 $configurator_camerarotationY = esc_attr(
   get_option("configurator_render_camRotationY")
 );
 $configurator_environmentName = esc_attr(
   get_option("configurator_render_environmentName")
 );
 $configurator_environmentRotation = esc_attr(
   get_option("configurator_render_environmentRotation")
 );
 $configurator_enviromentIntensity = esc_attr(
   get_option("configurator_render_environmentIntensity")
 );
 $configurator_render_imageWidth = esc_attr(
   get_option("configurator_render_imageWidth")
 );
 $configurator_render_imageHeight = esc_attr(
   get_option("configurator_render_imageHeight")
 );
 $configurator_boundingBoxFit = esc_attr(
   get_option("configurator_render_boundingBoxFit")
 );
 ?>
	 		connectorSettings = {
 		url: '<?php echo esc_url($configurator_url); ?>', // iOne url
 		schema: '<?php echo esc_attr($configurator_schema); ?>', // iOne scheme
 		version: '<?php echo esc_attr($configurator_version); ?>', // iOne version
 		assetPath: '<?php echo esc_url($configurator_cdn); ?>', // image cdn 3d models
 		assetIndex: '<?php echo esc_textarea($configurator_assets); ?>',
		 username: 'gast3',
		 password: 'gast3',
 		languageCode: '<?php echo esc_textarea(
     $configurator_language
   ); ?>', // German -> DE, English -> EN
 		gtm: '<?php echo esc_textarea($configurator_gtm); ?>', // GTM code
 		lightPresetsIndex: '<?php echo esc_textarea(
     $configurator_lightpresetsindex
   ); ?>', //
 		timeoutinMs: '<?php echo esc_attr($configurator_timeoutinms); ?>',
			 options: {
					 showStandaloneARButton: <?php if (empty($configurator_standaloneARButton)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 arEnabled: <?php if (empty($configurator_AREnabled)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 useStandaloneFloors: <?php if (empty($configurator_standaloneFloors)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 inlineAnswers: <?php if (empty($configurator_inlineAnswer)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 showAsConfigured: <?php if (empty($configurator_showAsConfigured)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 vrEnabled: <?php if (empty($configurator_vrEnabled)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 show3DWatermark: <?php if (empty($configurator_show3dwatermark)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 showTagFilter: <?php if (empty($configurator_showtagfilter)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 showZoomButton: <?php if (empty($configurator_showzoombutton)) {
        echo "false";
      } else {
        echo "true";
      } ?>,
					 showStockStatus: <?php if (empty($configurator_showstockstatus)) {
        echo "false";
      } else {
        echo "true";
      } ?>
				},
				renderParameters: {
	host: '<?php echo esc_textarea($configurator_renderhost); ?>',
	port: '<?php echo esc_textarea($configurator_renderport); ?>',
	secure: true,
	renderMode: '<?php echo esc_textarea($configurator_rendermode); ?>',
	settings: {
		camRotationX: '<?php echo esc_attr($configurator_camerarotationX); ?>',
		camRotationY: '<?php echo esc_attr($configurator_camerarotationY); ?>',
		environmentName:'<?php echo esc_textarea($configurator_environmentName); ?>',
		environmentRotation: '<?php echo esc_attr(
    $configurator_environmentRotation
  ); ?>',
		environmentIntensity:'<?php echo esc_attr(
    $configurator_enviromentIntensity
  ); ?>',
		imageWidth: '<?php echo esc_attr($configurator_render_imageWidth); ?>',
		imageHeight: '<?php echo esc_attr($configurator_render_imageHeight); ?>',
		boundingBoxFit: '<?php echo esc_attr($configurator_boundingBoxFit); ?>'
	}
}
}

		document.addEventListener('DOMContentLoaded', function(){

			// Adds the render button to the 2D image in the configurator
			<?php $configurator_renderbutton = get_option("configurator_render_button"); ?>
			var forcerenderbtn = '<?php if (empty($configurator_renderbutton)) {
     echo "false";
   } ?>';
			if ( forcerenderbtn === 'false'){
				document.getElementById("forcerender").style.display = "none";
			};

			/* Retrieving sku parameter from Woocommerce */
			<?php $configurator_sku = esc_attr($product->get_meta("_configurator_sku")); ?>
			<?php $configurator_convertedsku = esc_attr($product->get_sku()); ?>

			/*	 Woocommerce sku that was configured in the backend of the product page 	*/
						let sku =  '<?php if (empty($configurator_sku)) {
        echo esc_textarea($configurator_convertedsku);
      } else {
        echo esc_textarea($configurator_sku);
      } ?>';
						
			/* Setting sku and settings on selector object */
			document.getElementById('selector').setAttribute('sku', sku);
			document.getElementById('selector').setAttribute('settings', JSON.stringify(connectorSettings));

	
// add to the configurated product the description of the product when adding to cart.
			document.getElementById('selector').addEventListener('onArticleCreated', function(article) {
			console.log(event.detail);
			const cartData = article.detail;
			const obj = JSON.parse(cartData, function (key, value) {
			 if (key == 'configurationText') {
					document.getElementById("configurator_text").value = value;
				 }
				 if (key == 'price') {
	 				document.getElementById("configurator_price").value = value;
				 }
			});
		});

		// remove the loading .gif and clear the picture when the render image is recieved
			document.getElementById('selector').addEventListener('onRenderImageReceived', function (event) {
				random = Math.floor((Math.random()*100) + 1);
				image = event.detail + '?_' + random;
				//console.log(image);
				document.getElementById("render_img").src = image;
				 document.getElementById("loading-gif").style.display = "none";
					 document.getElementById("render_img").style.opacity = "1";
			});
		
			document.getElementById('selector').addEventListener('onAnswersAvailable', function (event) {
				if (event.detail == false) {
					jQuery(".addtocart").show();
				} else {
					jQuery(".addtocart").hide();
				}
			})
			document.getElementById('selector').addEventListener('onSelectionsReceived', function (event) {
				//console.log(event.detail)
				document.getElementById("loading-gif").style.display = "block";
				document.getElementById("render_img").style.opacity = "0.5";
			})
			/* Mobile selection drop (bottom) */
			jQuery("#selections-click").click(function(){
				jQuery("#selections-expand").toggleClass("expand-mobile");
			});


			jQuery(".animated_2d").click(function() {
			jQuery('.threed-viewer').addClass("twod");
			jQuery(".animated_2d").css({"opacity": "0.2", "pointer-events": "none"});
			jQuery(".animated_3d").css({"opacity": "1", "pointer-events": "auto"});
				jQuery('.threed-viewer').removeClass("expand-animated");
					return false;
		});
		jQuery(".animated_3d").click(function() {
			jQuery('.threed-viewer').removeClass("twod");
			jQuery(".animated_2d").css({"opacity": "1", "pointer-events": "auto"});
			jQuery(".animated_3d").css({"opacity": "0.2", "pointer-events": "none"});
				jQuery('.threed-viewer').addClass("expand-animated");
					return false;
		});

			// When pressing add to cart, this will press the hidden add to cart button from Woocommerce
			jQuery("#add-to-cart-modal").on('click', function(e){
				e.preventDefault();
				let selector = document.getElementById('selector');
				 selector.addToCart();
				 let listener = function() {
				jQuery('.single_add_to_cart_button').trigger('click');

					selector.removeEventListener('onArticleCreated', listener);
				 }
				 selector.addEventListener('onArticleCreated', listener);
				 });
			jQuery("#title_drop").click(function(){
				jQuery("#title_desc").toggleClass("expand-desc");
				jQuery("#title_drop").toggleClass("expand-desc");
			});
		}, false);

// Hide the add to cart button if the settings is checked on the product page in the backend.
		<?php $configurator_demo = $product->get_meta("_configurator_demo"); ?>
		var configuratordemo = '<?php echo esc_textarea($configurator_demo); ?>';
		if ( configuratordemo === 'yes'){
			document.getElementById("add-to-cart-modal").style.display = "none";
		};

 // hides the add to cart button if the option is checked on the product's page in the backend
		<?php $configurator_demo = $product->get_meta("_configurator_demo"); ?>
		var configuratordemo = '<?php echo esc_textarea($configurator_demo); ?>';
		var index;
		var list = document.getElementsByClassName("cart");
		if ( configuratordemo === 'yes'){
			for (index = 0; index < list.length; ++index) {
    list[index].style.display ="none";
			}
		};
	</script>
</body>
</html>
<?php get_footer("shop");

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
