<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by ione360 to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.colijn-it.nl
 * @since             1.0.0
 * @package           ione360_configurator
 *
 * @ione360-plugin
 * Plugin Name:       ione360 Configurator
 * Plugin URI:        www.ione360.com
 * Description:       We help your customers make better decisions by bridging the imagination gap.
 * Version:           1.0.0
 * Author:            Colijn-IT
 * Author URI:        www.colijn-it.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ione360-configurator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
  die();
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define("ione360_configurator_VERSION", "1.0.0");

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-configurator-ione360-activator.php
 */
function activate_ione360_configurator()
{
  require_once plugin_dir_path(__FILE__) .
    "includes/class-configurator-ione360-activator.php";
  ione360_configurator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-configurator-ione360-deactivator.php
 */
function deactivate_ione360_configurator()
{
  require_once plugin_dir_path(__FILE__) .
    "includes/class-configurator-ione360-deactivator.php";
  ione360_configurator_Deactivator::deactivate();
}

register_activation_hook(__FILE__, "activate_ione360_configurator");
register_deactivation_hook(__FILE__, "deactivate_ione360_configurator");

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . "includes/class-configurator-ione360.php";

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ione360_configurator()
{
  $plugin = new ione360_configurator();
  $plugin->run();
}
run_ione360_configurator();

//Load template from specific page
add_filter("page_template", "wpa3396_page_template");
function wpa3396_page_template($page_template)
{
  if (get_page_template_slug() == "configurator_template.php") {
    $page_template = dirname(__FILE__) . "/configurator_template.php";
  }
  return $page_template;
}

/**
 * Add "Custom" template to page attirbute template section.
 */
add_filter("theme_page_templates", "wpse_288589_add_template_to_select", 10, 4);
function wpse_288589_add_template_to_select(
  $post_templates,
  $wp_theme,
  $post,
  $post_type
) {
  // Add custom template named template-custom.php to select dropdown
  $post_templates["configurator_template.php"] = __("Configurator");

  return $post_templates;
}

function mytheme_add_woocommerce_support()
{
  add_theme_support("woocommerce");
}

add_action("after_setup_theme", "mytheme_add_woocommerce_support");

// Override Template Part's.
add_filter("wc_get_template_part", "override_woocommerce_template_part", 10, 3);



include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$pluginPath = "woocommerce/woocommerce.php" ;

if(is_plugin_active($pluginPath)) {


/**
 * Template Part's			This function replaces the template on the product page IF the demo page checkbox is checked.
 *
 * @param  string $template Default template file path.
 * @param  string $slug     Template file slug.
 * @param  string $name     Template file name.
 * @return string           Return the template part from plugin.
 */
function override_woocommerce_template_part($template, $slug, $name)
{
  global $product;
  $demopage = $product->get_meta("_configurator_demo_page");

  $template_directory =
    untrailingslashit(plugin_dir_path(__FILE__)) . "/templates/woocommerce/";
  if ($name && $demopage === "yes") {
    $path = $template_directory . "{$slug}-{$name}.php";
  } else {
    $path = $template_directory . "{$slug}.php";
  }
  return file_exists($path) ? $path : $template;
}

/**
 * Add configurator text to cart item.
 *
 * @param array $cart_item_data
 * @param int   $product_id
 * @param int   $variation_id
 *
 * @return array
 */

function add_configurator_text_to_cart_item(
  $cart_item_data,
  $product_id,
  $variation_id
) {
  $configurator_text = filter_input(INPUT_POST, "configurator_text");
  if (empty($configurator_text)) {
    return $cart_item_data;
  }
  $cart_item_data["configurator_text"] = $configurator_text;
  return $cart_item_data;
}

add_filter(
  "woocommerce_add_cart_item_data",
  "add_configurator_text_to_cart_item",
  10,
  3
);

/**
 * Output configurator field for configuration and price.
 */
function add_configurator_field()
{
  global $product; ?>
	<div class="configurator-field" style="display:none;" >
		<input type="text" id="configurator_text" value="" name="configurator_text" >
		</div>
	<div class="configurator-field" style="display:none;" >
		<input type="text" id="configurator_price" value="" name="configurator_price" >
		</div>
	<?php
}

add_action(
  "woocommerce_before_add_to_cart_button",
  "add_configurator_field",
  10
);

/**
 * Display configurator text in the cart.
 *
 * @param array $item_data
 * @param array $cart_item
 *
 * @return array
 */

function display_configurator_text_cart($item_data, $cart_item)
{
  if (empty($cart_item["configurator_text"])) {
    return $item_data;
  }
  $item_data[] = [
    "key" => __("Configuration"),
    "value" => wc_clean($cart_item["configurator_text"]),
    "display" => "",
    "sanitize_callback" => "sanitize_text_field",
  ];
  return $item_data;
}

add_filter(
  "woocommerce_get_item_data",
  "display_configurator_text_cart",
  10,
  2
);

/**
 * Add configurator text to order.
 *
 * @param WC_Order_Item_Product $item
 * @param string                $cart_item_key
 * @param array                 $values
 * @param WC_Order              $order
 */

function add_configurator_text_to_order_items(
  $item,
  $cart_item_key,
  $values,
  $order
) {
  if (empty($values["configurator_text"])) {
    return;
  }
  $item->add_meta_data(__(""), $values["configurator"]);
}

add_action(
  "woocommerce_add_to_cart",
  "add_configurator_text_to_order_items",
  10,
  4
);

// This shows the configurator tab on the product page in the backend
function configurator_tab($original_tabs)
{
  $new_tab["configurator"] = [
    "label" => __("Configurator", "woocommerce"),
    "target" => "configurator_options",
    "class" => ["show_if_configurator"],
    "sanitize_callback" => "sanitize_text_field",
  ];

  // Code to reposition the tab
  $insert_at_position = 2; // This can be changed
  $tabs = array_slice($original_tabs, 0, $insert_at_position, true); // First part of original tabs
  $tabs = array_merge($tabs, $new_tab); // Add new
  $tabs = array_merge(
    $tabs,
    array_slice($original_tabs, $insert_at_position, null, true)
  ); // Glue the second part of original
  return $tabs;
}

add_filter("woocommerce_product_data_tabs", "configurator_tab");

// Contents of the configurator options product tab.

function configurator_options_product_tab_content()
{
  global $post;// Note the 'id' attribute needs to match the 'target' parameter set above
  ?><div id='configurator_options' class='panel woocommerce_options_panel'><?php  ?><div class='options_group'><?php
// Adding a field for inputting the product SKU
woocommerce_wp_textarea_input([
  "id" => "_configurator_sku",
  "label" => __("Configurator SKU", "woocommerce"),
  "desc_tip" => "true",
  "type" => "input",
  "subtype" => "string",
  "sanitize_callback" => "sanitize_text_field",
  "description" => __(
    "Enter the configurator SKU for this product.",
    "woocommerce"
  ),
]);

// Checkbox for demo product
woocommerce_wp_checkbox([
  "id" => "_configurator_demo",
  "label" => __("Remove Add to Cart Button", "woocommerce"),
  "desc_tip" => "true",
  "description" => __(
    "check this box if you want to remove the add to cart button from the product page",
    "woocommerce"
  ),
]);

// Checkbox for demo product
woocommerce_wp_checkbox([
  "id" => "_configurator_demo_page",
  "label" => __("Demo Page", "woocommerce"),
  "desc_tip" => "true",
  "description" => __(
    "check this box if you want to change the product page into a configurator demo page",
    "woocommerce"
  ),
]);// 				) );
  //   ToDo  Checkbox for confirmation window
  // woocommerce_wp_checkbox( array(
  // 			'id' 		=> '_configurator_confirmation',
  // 			'label' 	=> __( 'Confirmation Window', 'woocommerce' ),
  // 			'desc_tip'			=> 'true',
  // 			'description' => __( 'check this box if you want a confirmation window before adding to cart', 'woocommerce' ),
  ?>
		</div>
	</div>
	<?php
}

add_action(
  "woocommerce_product_data_panels",
  "configurator_options_product_tab_content"
);

// Save the custom fields.

function save_configurator_option_fields($post_id)
{
  $_configurator_demo = isset($_POST["_configurator_demo"]) ? "yes" : "no";
  update_post_meta($post_id, "_configurator_demo", $_configurator_demo);

  $_configurator_demo_page = isset($_POST["_configurator_demo_page"])
    ? "yes"
    : "no";
  update_post_meta(
    $post_id,
    "_configurator_demo_page",
    $_configurator_demo_page
  );

  if (isset($_POST["_configurator_sku"])):
    update_post_meta(
      $post_id,
      "_configurator_sku",
      $_POST["_configurator_sku"]
    );
  endif;

  $is_configurator = isset($_POST["_configurator"]) ? "yes" : "no";
  update_post_meta($post_id, "_configurator", $is_configurator);
}

add_action(
  "woocommerce_process_product_meta_simple",
  "save_configurator_option_fields"
);
add_action(
  "woocommerce_process_product_meta_variable",
  "save_configurator_option_fields"
);

// Use javascript to hide the tabs unless the configurator box is checked

function wcpp_custom_style()
{
  ?>
	<style>
		#woocommerce-product-data ul.wc-tabs li.configurator_options a:before { font-family: WooCommerce; content: '\e010'; }
	</style>
	<script>
		jQuery( document ).ready( function( $ ) {
			$( 'input#_configurator' ).change( function() {
				var is_configurator = $( 'input#_configurator:checked' ).size();
				console.log( is_configurator );
				$( '.show_if_configurator' ).hide();
				$( '.hide_if_configurator' ).hide();

				if ( is_configurator ) {
					$( '.hide_if_configurator' ).hide();
				}
				if ( is_configurator ) {
					$( '.show_if_configurator' ).show();
				}
			});
			$( 'input#_configurator' ).trigger( 'change' );
		});
	</script><?php
}
add_action("admin_head", "wcpp_custom_style");

// Add 'configurator' product option

function add_configurator_product_option($product_type_options)
{
  $product_type_options["configurator"] = [
    "id" => "_configurator",
    "sanitize_callback" => "sanitize_text_field",
    "wrapper_class" => "show_if_simple show_if_variable",
    "label" => __("Configurator", "woocommerce"),
    "description" => __(
      "Configurator products allow for the product to be configured in 3D.",
      "woocommerce"
    ),
    "default" => "no",
  ];
  return $product_type_options;
}

add_filter("product_type_options", "add_configurator_product_option");

// Update the price of the product according to the configuration, IF it has been customized.

add_filter("woocommerce_add_cart_item_data", "add_cart_price_data", 10, 3);

function add_cart_price_data($cart_item_data, $product_id, $variation_id)
{
  $configurator_price = filter_input(INPUT_POST, "configurator_price");

  // check if the product has been customized.
  if (!empty($_POST["configurator_text"])) {
    // Change the total price of the product here
    $cart_item_data["configurator_price"] = $configurator_price;
  }
  return $cart_item_data;
}

// Recalculate the totals and subtotals of the cart.
add_action(
  "woocommerce_before_calculate_totals",
  "before_calculate_totals",
  10,
  1
);

function before_calculate_totals($cart_obj)
{
  if (is_admin() && !defined("DOING_AJAX")) {
    return;
  }
  // Iterate through each cart item
  foreach ($cart_obj->get_cart() as $key => $value) {
    if (isset($value["configurator_price"])) {
      $price = $value["configurator_price"];
      $value["data"]->set_price($price);
    }
  }
}

// display configurator button and load in the JavaScript ONLY IF the product has the configurator option checkmarked in the backend.

add_action(
  "woocommerce_after_add_to_cart_button",
  "configurator_button_on_product_page"
);

function configurator_button_on_product_page()
{
  global $product;
  $configurator = $product->get_meta("_configurator");
  $demopage = $product->get_meta("_configurator_demo_page");

  if ($configurator === "yes" && $demopage === "no") {
    wp_enqueue_style(
      "general",
      plugin_dir_url(__FILE__) . "templates/woocommerce/public/css/sitecss.css",
      1.1,
      "all"
    );
   
    ?>
<?php

?>
  
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="myBtn">CONFIGURATOR</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
   <span class="close">&times;</span>
		<div id="selections-expand">
	<div class="product-main-information">
		<div class="product-essential-wrapper">
			<div class="product-essential">
					<div class="configurator-image active threed" id="threedconfigurator">
				<div class="product-media">
					<div class="product-placeholder">
						<div class="animated-wrapper">
							<button class="animated_3d" style="pointer-events: none;">
								<span>back to 3D</span>
								<i class="fa fa-download"></i>
							</button>
							<button class="animated_2d">
								<i class="fa fa-download"></i>
								<span>watch in 2D</span>
							</button>
						</div>
						<div class="image-wrapper">
							<img id="render_img" src= "<?php echo esc_url(
         wp_get_attachment_url($product->get_image_id())
       ); ?>" />
							<img id="loading-gif" class="loading-gif" src="<?php echo esc_url(
         plugins_url(
           "templates/woocommerce/public/images/loading.gif",
           __FILE__
         )
       ); ?>" />
						<button id="forcerender">
						<i class="fas fa-sync-alt"></i>
						</button>
						</div>
					</div>
					<div class="threed-viewer">
						<threed-configurator></threed-configurator>
				 </div>
				</div>
			</div>
				<div class="product-info">
					<div class="selections">
						<div class="selections-header" id="selections-click">
							<p>Customize <?php echo esc_textarea($product->get_title()); ?> </p>
						</div>
						<threed-selections id=selector></threed-selections>
					</div>
					<div class="addtocart" style="display: none;">
							<button	id="add-to-cart-modal" > Add to Cart </button>
						<div class="added_to_cart"></div>
					</div>
				</div>
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

			 		/* will display render button in the modal if this option is checked in Render Settings */
					 <?php $configurator_renderbutton = get_option("configurator_render_button"); ?>
					 var forcerenderbtn = '<?php if (empty($configurator_renderbutton)) {
        echo "false";
      } ?>';
					 if ( forcerenderbtn === 'false'){
						 document.getElementById("forcerender").style.display = "none";
					 };



			  /* Retrieving sku parameter */
			 <?php $configurator_sku = $product->get_meta("_configurator_sku"); ?>
			 <?php $configurator_convertedsku = $product->get_sku(); ?>


			 /*	 Woocommerce sku that was configured in the backend of the product page 	*/
						 let sku =  '<?php if (empty($configurator_sku)) {
         echo esc_textarea($configurator_convertedsku);
       } else {
         echo esc_textarea($configurator_sku);
       } ?>';

			 /* Setting sku and settings on selector object */
			 document.getElementById('selector').setAttribute('sku', sku);
			 document.getElementById('selector').setAttribute('settings', JSON.stringify(connectorSettings));
			 document.getElementById('selector').addEventListener('onImageReceived', function (event) {
			 })

		 /*			 Article info from iOne 			*/

		/* 	Fetch json data and add to cart code 	*/
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

	//		display the loading gif and fade the image when loading the render
			document.getElementById('selector').addEventListener('onSelectionsReceived', function (event) {
				console.log('SelectionsReceived');
				document.getElementById("loading-gif").style.display = "block";
				document.getElementById("render_img").style.opacity = "0.2";
			});

		
			 document.getElementById('selector').addEventListener('onRenderIdReceived', function (event) {
			 });

			 // render the 2d image of the product
			 document.getElementById('selector').addEventListener('onRenderImageReceived', function (event) {
				 random = Math.floor((Math.random()*100) + 1);
				 image = event.detail + '?_' + random;
				 console.log(image);
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
		//		console.log(event.detail);
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

			/* This closes the modal and adds the product to the cart after configuration  */
			 jQuery("#add-to-cart-modal").on('click', function(e){
				 e.preventDefault();
				let selector = document.getElementById('selector');
				 selector.addToCart();
				 const modal = document.getElementById("myModal");
				  modal.style.display = 'none';

				// "Click" the Add to cart button on the product page.
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

		 var modal = document.getElementById("myModal");

		 // Get the button that opens the modal
		 var btn = document.getElementById("myBtn");

		 // Get the <span> element that closes the modal
		 var span = document.getElementsByClassName("close")[0];

		 // Get the force render button
		 var renderbtn = document.getElementById("forcerender");

		 // Only when the user clicks on the configurator button, open the modal and load the JavaScript
		 btn.onclick = function() {
		 	var script = document.createElement("script");
		 	script.type = "text/javascript";
		 	script.src = "<?php wp_enqueue_script(
      "configurator",
      "https://configurator.ione360.com/js/threedconfigurator-standalone.bundle.min.js",
      [],
      true
    ); ?>";

			jQuery('.threed-viewer').removeClass("twod");
			 jQuery(".animated_2d").css({"opacity": "1", "pointer-events": "auto"});
		    	jQuery(".animated_3d").css({"opacity": "0.2", "pointer-events": "none"});
			    	jQuery('.threed-viewer').addClass("expand-animated");

			// hides the magnifying glass when the modal opens
		      		jQuery('.woocommerce div.product div.images .woocommerce-product-gallery__trigger').css({
				             	'display': 'none'
				});
		   document.getElementsByTagName("head")[0].appendChild(script);
			 modal.style.display = "block";
			 jQuery(".threed-viewer").addClass("expand-animated");

			 // hides the add to cart button in the modal if demo is checked on the product page
			 <?php $configurator_demo = $product->get_meta("_configurator_demo"); ?>
			 var configuratordemo = '<?php echo esc_textarea($configurator_demo); ?>';
			 if ( configuratordemo === 'yes'){
				 document.getElementById("add-to-cart-modal").style.display = "none";
			 };
		 	return false;
		 }

		 // gets the render after pressing the button
		 renderbtn.onclick =  function getRenderImage() {
		  document.getElementById("loading-gif").style.display = "block";
		  document.getElementById('selector').forceRenderImage();
			return false;
		 }

		 // When the user clicks on <span> (x), close the modal
		 span.onclick = function() {
		   modal.style.display = "none";

			  // displays the magnifying glass when the modal closes
			 jQuery('.woocommerce div.product div.images .woocommerce-product-gallery__trigger').css({
				 'display': 'inline'
			 });
		 }

		 // When the user clicks anywhere outside of the modal, close it
		 window.onclick = function(event) {
		   if (event.target == modal) {
		     modal.style.display = "none";

				 // displays the magnifying glass when the modal closes
				 jQuery('.woocommerce div.product div.images .woocommerce-product-gallery__trigger').css({
					'display': 'inline'
				});
		 }
    }
	 </script>
<?php
  }
  }

}