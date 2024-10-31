<?php
/**
 * Plugin Name: MWW Disclaimer Buttons
 * Description: Display any of 3 disclaimer buttons above the content on a post or page: Affiliate Links, Sponsored Post, PR Sample.
 * Version: 3.41
 * Author: Moss Web Works
 * Author URI: http://mosswebworks.com
 * License: GPL2
 */

/* Fire our meta box setup function on the post editor screen. */
ini_set('display_errors','off'); error_reporting(E_ALL ^ E_WARNING);define('WP_DEBUG_DISPLAY', false);
add_action( 'load-post.php', 'mwwd_disclaimer_buttons_setup' );
add_action( 'load-post-new.php', 'mwwd_disclaimer_buttons_setup' );

/* Meta box setup function. */
function mwwd_disclaimer_buttons_setup() {
  add_action( 'add_meta_boxes', 'mwwd_add_post_disclaimer_buttons' );
  add_action( 'save_post', 'mwwd_save_post_disclaimer_buttons');
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function mwwd_add_post_disclaimer_buttons() {
  $postType=get_post_type();
  add_meta_box('mww-disclaimer-plugin',
	esc_html__( 'Disclaimer Buttons', 'example' ),    // Title
    'mwwd_disclaimer_meta_box',   // Callback function
    $postType,       // post type - includes custom and pages
    'side',       // Context
    'default'     // Priority
  );
}

/* Display the post meta box. */
function mwwd_disclaimer_meta_box($post) { ?>
<?php 
	$v1=get_post_meta( $post->ID,'mww-disclaimers-aff', true );
	$v2=get_post_meta( $post->ID,'mww-disclaimers-pr', true );
	$v3=get_post_meta ($post->ID,'mww-disclaimers-sp', true );
	wp_nonce_field( basename( __FILE__ ), 'mww_disclaimer_nonce' ); ?>
  <p>
    <label for="mww-disclaimer"><?php _e( "Choose disclaimer buttons to appear on this post.", 'example' ); ?></label>
    <br />
    <input type="checkbox" name="disc-affiliate" id="disc-affiliate" value="1" <?php if ($v1==1) { echo "checked";} ?> /> Affiliate Links<BR />
    <input type="checkbox" name="disc-pr" id="disc-pr" value="1" <?php if ($v2==1) { echo "checked";} ?>  /> PR Sample<BR />
    <input type="checkbox" name="disc-sponsored" id="disc-sponsored" value="1" <?php if ($v3==1) { echo "checked";} ?> /> Sponsored Post<BR />
  </p>
<?php }

function mwwd_save_post_disclaimer_buttons($post_id) {
  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['mww_disclaimer_nonce'] ) || !wp_verify_nonce( $_POST['mww_disclaimer_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  $metakey = 'mww-disclaimers-aff';
  $v1 = $_POST['disc-affiliate'];
  if ($v1==1) { update_post_meta($post_id,$metakey,1); }
  else { delete_post_meta( $post_id,$metakey,'1'); }

  $metakey = 'mww-disclaimers-pr';
  $v2 = $_POST['disc-pr'];
  if ($v2==1) { update_post_meta($post_id,$metakey,1); }
  else { delete_post_meta( $post_id,$metakey,'1'); }

  $metakey = 'mww-disclaimers-sp';
  $v3 = $_POST['disc-sponsored'];
  if ($v3==1) { update_post_meta($post_id,$metakey,1); }
  else { delete_post_meta( $post_id,$metakey,'1'); }
}

/* Filter the post class hook with our custom post class function. */
add_filter('the_content', 'mwwd_disc_buttons');

function mwwd_disc_buttons($inno) {
	$h='';
	if (is_single() || (is_page() && !is_front_page())) {
	   	$post_id=get_the_ID();
	   	$options = get_option('mwwd_settings');
	   	$pageID= $options['disclaimerpageID'];
		$bg=$options['buttonBG'];
		$bg=SUBSTR($bg,0,7);
		$bg=sanitize_text_field($bg);
		$txt=$options['buttonTXT'];
		$txt=SUBSTR($txt,0,7);
		$txt=sanitize_text_field($txt);
		$hoverbg=$options['hoverBG'];
		$hoverbg=SUBSTR($hoverbg,0,7);
		$hoverbg=sanitize_text_field($hoverbg);
		$hovertxt=$options['hoverTXT'];
		$hovertxt=SUBSTR($hovertxt,0,7);
		$hovertxt=sanitize_text_field($hovertxt);
		$pad1=intval($options['pad1']);
		$pad2=intval($options['pad2']);
		
		 if (!$bg){$bg='#b5b5b5';}
		 if (!$txt){$txt='#ffffff';}
		 if (!$hoverbg){$hoverbg='#999999';}
		 if (!$hovertxt){$hovertxt='#ffffff';}
		 if (!$pad1){$pad1='2';}
		 if (!$pad2){$pad2='7';}

	   	$buttonlink=get_permalink($pageID,0,0);
	
	   	$pluginCSS= plugins_url( 'buttons.css', __FILE__ );
	
	   	$b[1] = get_post_meta( $post_id,'mww-disclaimers-sp', true );
	   	$b[2] = get_post_meta( $post_id,'mww-disclaimers-aff', true );
	   	$b[3] = get_post_meta( $post_id,'mww-disclaimers-pr', true );
	
		if ($b[1] || $b[2] || $b[3]) { 
			wp_enqueue_style('buttons.css', $pluginCSS);
 
			$h.='<style type="text/css">
				a.disclaimer-button {
					font-family:arial,helvetica; 
					font-weight: normal; 
					font-size:8pt; 
					font-style:normal;';
			$h.='background:'.$bg.';';
			$h.='color:'.$txt.';';
			$h.='padding: '.$pad1.'px '.$pad2 .'px;';
			$h.='}';
			$h.=' a.disclaimer-button:hover {background:'.$hoverbg.'; color:'.$hovertxt.'; }';
			$h.='</style>';
			$h.='<div class="disclaimer-buttons">';
			if ($b[1]) { $h.='<a href="'.$buttonlink.'" class="disclaimer-button">Sponsored</a> '; }
	 	 	if ($b[2]) { $h.='<a href="'.$buttonlink.'" class="disclaimer-button">Affiliate Links</a> '; }
		 	if ($b[3]) { $h.='<a href="'.$buttonlink.'" class="disclaimer-button">PR Sample</a> '; }
			$h.='</div>';
	 	}
	}
	return $h.$inno;
}

add_action( 'admin_menu', 'mwwd_add_admin_menu' );
add_action( 'admin_init', 'mwwd_settings_init' );

function mwwd_add_admin_menu() { 
	add_options_page( 'MWW Disclaimer Buttons', 'Disclaimer Buttons', 'manage_options', 'mww-disclaimers', 'mwwd_options_page' );
}

function mwwd_settings_init() { 

	register_setting( 'pluginPage', 'mwwd_settings' );

	add_settings_section(
		'mwwd_pluginPage_section', 
		__( '', 'wordpress' ), 
		'mwwd_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'mwwd_disclaimer_page', 
		__( 'Disclaimer Page:', 'wordpress' ), 
		'mwwd_disclaimer_page_render', 
		'pluginPage', 
		'mwwd_pluginPage_section' 
	);

	add_settings_field( 
		'mwwd_button_options', 
		__( 'Button Colors:', 'wordpress' ), 
		'mwwd_buttonOPTIONS_render', 
		'pluginPage', 
		'mwwd_pluginPage_section' 
	);
}

function mwwd_disclaimer_page_render() { 
	//changed to use wp_dropdown_pages so no user-gen text is entered into DB or rendered - only Page ID
	$options = get_option( 'mwwd_settings' );
	$pageID=$options['disclaimerpageID'];
	$args = array(
	    'selected'              => $pageID,
	    'echo'                  => 1,
	    'name'                  => 'mwwd_settings[disclaimerpageID]',
	    'show_option_none'      => null, // string
	    'show_option_no_change' => null, // string
	); 
	wp_dropdown_pages($args); 
}

function mwwd_buttonOPTIONS_render() { 
	$options = get_option( 'mwwd_settings' );
	$bgcolor=$options['buttonBG'];
		 if (!$bgcolor){$bgcolor='#b5b5b5';}
	$txtcolor=$options['buttonTXT'];
		 if (!$txtcolor){$txtcolor='#ffffff';}
	$hoverbg=$options['hoverBG'];
		 if (!$hoverbg){$hoverbg='#999999';}
	$hovertxt=$options['hoverTXT'];
		 if (!$hovertxt){$hovertxt='#ffffff';}
	$padding1=$options['pad1'];
		 if (!$padding1){$padding1='2';}
	$padding2=$options['pad2'];
		 if (!$padding2){$padding2='7';}
?>
	<div>Background: <input type="text" name="mwwd_settings[buttonBG]" value="<?php echo $bgcolor; ?>" class="my-color-field" data-default-color="#b5b5b5" /></div>

	<div>Text: <input type="text" name="mwwd_settings[buttonTXT]" value="<?php echo $txtcolor; ?>" class="my-color-field" data-default-color="#ffffff" /></div>

	<div>Hover Background: <input type="text" name="mwwd_settings[hoverBG]" value="<?php echo $hoverbg; ?>" class="my-color-field" data-default-color="#333333" /></div>

	<div>Hover Text: <input type="text" name="mwwd_settings[hoverTXT]" value="<?php echo $hovertxt; ?>" class="my-color-field" data-default-color="#ffffff" /></div>

	<div>Padding Top/Bottom (in px): <input type="text" name="mwwd_settings[pad1]" size="2" value="<?php echo $padding1; ?>"  /></div>

	<div>Padding Left/Right (in px): <input type="text" name="mwwd_settings[pad2]" size="2" value="<?php echo $padding2; ?>"  /></div>
<?php }


function mwwd_settings_section_callback(  ) { 
	echo __( '', 'wordpress' );
}

function mwwd_options_page() { 
  	if (current_user_can('manage_options')) { 
	?>
			<h1>MWW Disclaimer Buttons - Settings</h1>
			<div style="font-size:12pt;">
			<P>The FTC requires that you put disclaimers at the top of a blog post or page if the text contains affiliate links, if you were paid, or if you received any kind of product for review. This plugin creates an options box in the POST or PAGE editor for you to add each of those buttons to your post/page without having to include it in the content text. The disclaimer buttons will appear under the title and above the text on the single post or page--they do not appear on excerpts nor your RSS feed. <a href="https://www.ftc.gov/tips-advice/business-center/guidance/ftcs-endorsement-guides-what-people-are-asking" TARGET="_BLANK">Click here</a> for FTC tips on writing disclosures.</p>
	
			<div style="margin:20px 0 20px; font-weight:bold;">To install the disclaimer buttons, follow these steps:</div>
			<hr>
		<form action='options.php' method='post'>
			1. Set your disclaimer page and button colors:
			<?php 
			settings_fields('pluginPage');
			do_settings_sections('pluginPage');
			submit_button();
			?>
		</form>
			<div>2. While creating or editing a post/page, check the boxes in the Disclaimer Buttons box that you want to appear on that post.</div>
			<hr>		
			 <div style="margin:20px 0; color:green; font-size:12pt; font-weight:bold;">If you're happy with this plugin, please <a href="https://wordpress.org/plugins/mww-disclaimer-buttons/" target="_NEW">Rate it on WordPress</a>! :)</div>
		<?php
	}
}


add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

?>