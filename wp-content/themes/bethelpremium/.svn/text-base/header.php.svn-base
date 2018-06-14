<!DOCTYPE html>

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<!-- BEGIN head -->
<head>

	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<!-- Title -->
        <title><?php is_home() ? bloginfo('name') : wp_title('',True) ?> | Blogs | Bethel University Minnesota</title>
	<!-- <title><?php //wp_title('|', true, 'right'); ?><?php // bloginfo('name'); ?> | Blogs | Bethel University Minnesota</title> -->

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

	<!-- RSS & Pingbacks -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php if (get_option('tz_feedburner')) { echo get_option('tz_feedburner'); } else { bloginfo( 'rss2_url' ); } ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<script type="text/javascript">
  var disqus_developer = 1;
</script>

    <!-- Theme Hook -->
	<?php wp_head(); ?>

<!-- google analytics code -->
 <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1888141-16']);
  _gaq.push(['_setDomainName', '.bethel.edu']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 </script>

<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>

	<!-- BEGIN #container -->
	<div id="container">

		<!-- BEGIN #header -->
		<div id="header">

			<!-- BEGIN .inner -->
			<div class="inner">

                <div id="top-nav">

					<?php if ( has_nav_menu( 'primary-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
                    <?php wp_nav_menu( array( 'theme_location' => 'primary-menu') ); ?>
                    <?php } else { /* else use wp_list_categories */
                    $primary_exclude = get_option('tz_primary_nav_exclude'); ?>

                    <ul>
                        <?php // wp_list_pages( array( 'exclude' => $primary_exclude, 'title_li' => '' )); ?>
                    </ul>
                    <?php } ?>

				</div>

				<p class="welcome-message"><?php echo stripslashes(get_option('tz_welcome_message')); ?></p>

			<!-- END .inner -->
			</div>

		<!--END #header-->
		</div>

		<!--BEGIN #content -->
		<div id="content" class="unit_2-3" class="clearfix">

