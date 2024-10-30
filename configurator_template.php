<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the iOne360 construct of pages
 * and that other 'pages' on your iOne360 site may use a
 * different template.
 * @link              www.colijn-it.nl
 * @since             1.0.0
 * @package           ione360_configurator
 *
 */

/*
Template name: configurator
*/

get_header();

wp_enqueue_style(
  "general",
  plugin_dir_url(__FILE__) . "public/css/general.css",
  1.1,
  "all"
);
wp_enqueue_script(
  "configurator",
  "https://configurator.ione360.com/js/threedconfigurator-standalone.bundle.min.js",
  [],
  true
);

global $wpdb;
$sku = $wpdb->get_var(
  "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'configurator sku'"
);
?>
	<meta charset="UTF-8">
	<base href=".">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <div id="selections-expand test<?php echo esc_textarea($sku); ?>">
	 <div class="product-main-information">
		<div class="product-essential-wrapper">
			<div class="product-essential">
				<div class="configurator-image active threed" id="threedconfigurator">
					<threed-configurator></threed-configurator>
					<div class="animated-wrapper">
						<button class="animated_3d">
							<span>back to 3D</span>
							<i class="fa fa-download"></i>
						</button>
						<button class="animated_2d">
							<i class="fa fa-download"></i>
							<span>watch in 2D</span>
						</button>
					</div>
					<div class="product-placeholder">
						<div class="image-wrapper">
							<img id="render_img" src="" />
						</div>
						<div id="loading-gif">
							<img src="<?php echo esc_url(
         plugins_url("public/images/loading.gif", __FILE__)
       ); ?>"/>
						</div>
					</div>
					<div class="force-render">
						<span id="RenderIcon" onclick="getRenderImage()" class="getrender" title="Get render">
							<i class="fa fa-download"></i>
						</span>
					</div>
				</div>
				<div class="product-info">
					<div class="configurator-data">
						<div class="product-name">
							<h1 id="title_wrapper"></h1>
						</div>
						<div class="short-description">
							<p id ="title_desc"></p>
							<span id="title_drop">more info</span>
						</div>
					</div>
					<div class="selections">
						<div class="selections-header" id="selections-click">
							<p>Customize</p>
						</div>
						<threed-selections id=selector></threed-selections>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

/* iOne connection settings */
		<?php
  $configurator_url = esc_attr(get_option("configurator_endpoint_setting"));
  $configurator_schema = esc_attr(get_option("configurator_scheme_setting"));
  $configurator_version = esc_attr(get_option("configurator_version_setting"));
  $configurator_cdn = esc_attr(get_option("configurator_cdn_setting"));
  $configurator_assets = esc_attr(get_option("configurator_assets_setting"));
  $configurator_language = esc_attr(
    get_option("configurator_language_setting")
  );
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
    <?php $sku = $wpdb->get_var(
      "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'configurator sku'"
    ); ?>

    	let sku = '<?php echo esc_textarea($sku); ?>';

			/* Setting sku and settings on selector object */
			document.getElementById('selector').setAttribute('sku', sku);
			document.getElementById('selector').setAttribute('settings', JSON.stringify(connectorSettings));
			document.getElementById('selector').addEventListener('onImageReceived', function (event) {
			})

			document.getElementById('selector').addEventListener('onRenderImageReceived', function (event) {
				random = Math.floor((Math.random()*100) + 1);
				image = event.detail + '?_' + random;
				console.log(image);
				document.getElementById("render_img").src = image;
				document.getElementById("loading-gif").style.display = "none";
			});
			document.getElementById('selector').addEventListener('onAnswersAvailable', function (event) {
				if (event.detail == false) {
					jQuery(".addtocart").show();
					console.log('test');
				} else {
					jQuery(".addtocart").hide();
					console.log('test2');
				}
			})
			document.getElementById('selector').addEventListener('onSelectionsReceived', function (event) {
				console.log('SelectionsReceived');
				document.getElementById("loading-gif").style.display = "block";
			})
			/* Mobile selection drop (bottom) */
			jQuery("#selections-click").click(function(){
				jQuery("#selections-expand").toggleClass("expand-mobile");
			});
			jQuery("#title_drop").click(function(){
				jQuery("#title_desc").toggleClass("expand-desc");
				jQuery("#title_drop").toggleClass("expand-desc");
			});

		}, false);
		jQuery(".animated_2d").click(function() {
			jQuery('.configurator-image').addClass('twod');
			jQuery('.configurator-image').removeClass('threed');
		});
		jQuery(".animated_3d").click(function() {
			jQuery('.configurator-image').removeClass('twod');
			jQuery('.configurator-image').addClass('threed');
		});
		/* Render button */
		function getRenderImage() {
			document.getElementById("loading-gif").style.display = "block";
			document.getElementById('selector').forceRenderImage();
		}
		function addClickToCart() {
			document.getElementById('selector').addToCart();
		}
		function getExpandView() {
			 document.getElementById("selections-expand").classList.toggle("expanded");
		}
	</script>
<?php get_footer();
