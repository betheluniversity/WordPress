<?php

/* 
	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!
*/

/*-----------------------------------------------------------------------------------*/
/*	Theme Localisation
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain ('framework');


/*-----------------------------------------------------------------------------------*/
/*	Register WP3.0+ Menus
/*-----------------------------------------------------------------------------------*/

function register_menu() {
	register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_menu');


/*-----------------------------------------------------------------------------------*/
/*	Sidebars
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Page Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Area 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Area 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Area 3',
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Area 4',
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}


/*-----------------------------------------------------------------------------------*/
/*	Thumbnails
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );
	//**** BETHEL change the last variable to "false", as we want non-cropped thumbnails
	set_post_thumbnail_size( 150, 150, false ); // Normal post thumbnails
	add_image_size( 'archive-thumb', 570, 300, true ); // Post thumbs
	add_image_size( 'gallery-thumb', 166, 140, true ); // Gallery thumbs
}

/*-----------------------------------------------------------------------------------*/
/*	Excerpt Length
/*-----------------------------------------------------------------------------------*/

function tz_excerpt_length($length) {
return 55; }
add_filter('excerpt_length', 'tz_excerpt_length');


/*-----------------------------------------------------------------------------------*/
/*	Exerpt More
/*-----------------------------------------------------------------------------------*/

function tz_excerpt_more($excerpt) {
return str_replace('[...]', '...', $excerpt); }
add_filter('wp_trim_excerpt', 'tz_excerpt_more');


/*-----------------------------------------------------------------------------------*/
/*	Scripts
/*-----------------------------------------------------------------------------------*/

function tz_google_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', false, '1.4.2');
		wp_register_script('validation', 'http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js', 'jquery');
		wp_register_script('color', get_template_directory_uri().'/js/jquery.color.js', 'jquery');
		wp_register_script('tz_custom', get_template_directory_uri().'/js/jquery.custom.js', 'jquery', true);
		wp_register_script('superfish', get_template_directory_uri().'/js/superfish.js', 'jquery');
		wp_register_script('tabbed', get_template_directory_uri().'/js/jquery.tabbed-widget.js', array('jquery-ui-tabs'));
		wp_register_script('jquery-ui-custom', get_template_directory_uri() . '/js/jquery-ui-1.8.5.custom.min.js', 'jquery');
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-custom');
		wp_enqueue_script('color');
		wp_enqueue_script('superfish');
		wp_enqueue_script('tz_custom');
	}
}
add_action('init', 'tz_google_jquery');


// load custom script which shows on the contact page.
function tz_contact_js() {
	if (is_page_template('template-contact.php') ) wp_enqueue_script('validation');
}
add_action('wp_print_scripts', 'tz_contact_js');

// load single scripts only on single pages
function tz_single_scripts() {
	if(is_singular()) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments 
}
add_action('wp_print_scripts', 'tz_single_scripts');


// load validation js for contact form template
function tz_contact_validate() {
	if (is_page_template('template-contact.php')) { ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#contactForm").validate();
			});
		</script>
	<?php }
}
add_action('wp_head', 'tz_contact_validate');


/*-----------------------------------------------------------------------------------*/
/*	Body Class
/*-----------------------------------------------------------------------------------*/

add_filter('body_class','tz_browser_body_class');
function tz_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


// Output the styling for the seperated Pings
function tz_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


/*-----------------------------------------------------------------------------------*/
/*	Comments
/*-----------------------------------------------------------------------------------*/

function tz_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<?php echo get_avatar($comment,$size='50'); ?>
			<div class="comment-author vcard clearfix">
				<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
			</div>			
			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
			</div>
			
			<div class="comment-text clear">
				<?php if ($comment->comment_approved == '0') : ?>
				<span class="moderation"><?php _e('Your comment is awaiting moderation.') ?></em></span>
				<?php endif; ?>
				<?php comment_text() ?>
			</div>		
			
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'reply_text' => 'Reply &rarr;', 'max_depth' => $args['max_depth']))) ?>	
		</div>
<?php
        }

/*-----------------------------------------------------------------------------------*/
/*	Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/

// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 300x250 Ad Block Custom Widget
include("functions/widget-ad250x250.php");

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");

// Add the Flickr Photos Custom Widget
include("functions/widget-flickr.php");

// Add the Custom Video Widget
include("functions/widget-video.php");

// Add the Tabbed Content Widget
include("functions/widget-tabbed.php");

// Add the Theme Shortcodes
include("functions/theme-shortcodes.php");


/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Load Theme Options
/*-----------------------------------------------------------------------------------*/

define('TZ_FILEPATH', TEMPLATEPATH);
define('TZ_DIRECTORY', get_template_directory_uri());

require_once (TZ_FILEPATH . '/admin/admin-functions.php');
require_once (TZ_FILEPATH . '/admin/admin-interface.php');
require_once (TZ_FILEPATH . '/functions/theme-options.php');
require_once (TZ_FILEPATH . '/functions/theme-functions.php');
require_once (TZ_FILEPATH . '/tinymce/tinymce.loader.php');

/*-----------------------------------------------------------------------------------*/
/*      Bethel Custom Theme Modifiers
/*-----------------------------------------------------------------------------------*/

remove_action('wp_head', 'wp_generator');

add_action('show_user_profile','read_only_profile_inputs');

function read_only_profile_inputs() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $(\'#first_name\').attr(\'readonly\', \'readonly\'); 
        $(\'#last_name\').attr(\'readonly\', \'readonly\');
        $(\'#nickname\').attr(\'readonly\', \'readonly\');
        $(\'#email\').attr(\'readonly\', \'readonly\');
        $("#display_username").attr("disabled","disabled");
        $("#display_firstname").attr("disabled","disabled");
        $("#display_lastname").attr("disabled","disabled");
        $("#display_lastfirst").attr("disabled","disabled");
     });
    </script>
';
}

function remove_menus () {
  global $menu;
  $restricted = array(__('Pages'));
  end ($menu);
  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
      if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
  }
}
add_action('admin_menu', 'remove_menus');

function remove_submenu() {
  global $submenu;
  //remove Theme editor
  unset($submenu['themes.php'][5]);
  //typekit plugin menu
  unset($submenu['options-general.php'][41]);
    //remove the delete blog option
  unset($submenu['tools.php'][25]);
}
add_action('admin_head', 'remove_submenu');

//make email address in the site admin be read-only
function read_only_admin_settings_general() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $("#new_admin_email").attr("readonly", "readonly"); 
        $("[name=time_format]").attr("disabled","disabled");
        $("[name=time_format_custom]").attr("readonly", "readonly"); 
     });
    </script>
';
}

add_action('admin_head-options-general.php', 'read_only_admin_settings_general');

//disable the ability to shut off the notification for comments
function admin_settings_general_discussion() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $("#comments_notify").attr("DISABLED","true");
     });
    </script>
';
}

add_action('admin_head-options-discussion.php', 'admin_settings_general_discussion');


//removes 'Add New' user button
function admin_settings_add_new_user() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $(".add-new-h2").remove();
     });
    </script>
';
}

add_action('admin_head-users.php', 'admin_settings_add_new_user');

//remove the notice to upgrade
function admin_notices() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $(".update-nag").remove();
        $("#disqus_warning").remove();
        $("a[title=\'Log Out\']").remove();
     });
    </script>
';
}
add_action('admin_head','admin_notices');

//make encoding for pages and feeds in the settings reading be read-only
function admin_settings_general_reading() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $("#blog_charset").attr("readonly","true");
     });
    </script>
';
}

add_action('admin_head-options-reading.php', 'admin_settings_general_reading');

//removes Pages option in the menu mangement area
function admin_settings_remove_pages_menu() {
  echo '
    <script type="text/javascript">
     jQuery(document).ready(function($){
        $("#add-page").remove();
     });
    </script>
';
}

add_action('admin_head-nav-menus.php', 'admin_settings_remove_pages_menu');


function bethel_addRssImage() {
  global $post;
  if(has_post_thumbnail($post->ID))
    echo get_the_post_thumbnail($post->ID, 'thumbnail');
}

add_action('rss2_item', 'bethel_addRssImage');

