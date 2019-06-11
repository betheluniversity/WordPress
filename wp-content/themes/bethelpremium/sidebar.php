		<!--BEGIN #sidebar .aside-->
		<div id="sidebar" class="aside">
		
			<!-- BEGIN #logo -->
			<div id="logo">
				<?php /*
				If "plain text logo" is set in theme options then use text
				if a logo url has been set in theme options then use that
				if none of the above then use the default logo.png */
				if (get_option('tz_plain_logo') == 'true') { ?>
				<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<p id="tagline"><?php bloginfo( 'description' ); ?></p>
				<?php } elseif (get_option('tz_logo')) { ?>
				<a class="logo-link" href="<?php echo home_url(); ?>"><img src="<?php echo get_option('tz_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
				<?php } else { ?>
				<a class="logo-link" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" width="190" height="190" /></a>
				<!-- <a class="logo-link" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" width="190" height="190" /></a> -->
				<?php } ?>
			<!-- END #logo -->
			</div>
			
            
            <?php if(!is_page()) : ?>
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar()) ?>
			<?php else: ?>
            <?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Page sidebar')) ?>
            <?php endif; ?>
		
		<!--END #sidebar .aside-->
		</div>