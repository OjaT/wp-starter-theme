<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<main>
	<section>
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>    
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>