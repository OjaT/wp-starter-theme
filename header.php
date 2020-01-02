<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php do_action('meta'); ?>
<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet"> 
<?php wp_head(); ?>
<?php do_action('analytics'); ?> 
</head>
<body <?php dynamicBodyID() ?>>
<header class="header">
	<div class="container">
		<a class="logo" href="<?php bloginfo('home') ?>"></a>
		<?php wp_nav_menu( array('menu'=> 'Main', 'container' => 'nav', 'container_class'=> 'top' ) ); ?>
		<span class="icon mobile-nav" id="mob-nav"></span>

		<div class="lang-select">
			<?php 
				$url = get_the_permalink();
				$wpml_permalink_et = apply_filters( 'wpml_permalink', $url , 'et' );
				$wpml_permalink_en = apply_filters( 'wpml_permalink', $url , 'en' );
			?>
			<?php 
				if ( ICL_LANGUAGE_CODE=='en') {
					$activeEN = 'active';
				} 
				if ( ICL_LANGUAGE_CODE=='et' ) {
					$activeET = 'active';
				}
			?>	 
			<a href="<?php echo $wpml_permalink_et; ?>" <?php if ( $activeET ) { ?> class="<?php echo $activeET; ?>"<?php } ?>><span>EST</span></a>
			<a href="<?php echo $wpml_permalink_en; ?>" <?php if ( $activeEN ) { ?> class="<?php echo $activeEN; ?>"<?php } ?>><span>ENG</span></a>	
		</div>
	</div>
</header>