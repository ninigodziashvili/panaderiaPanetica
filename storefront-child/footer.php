<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 */
			do_action( 'storefront_footer' );
			?>
<p>Pan sin gluten, sano, sabroso y hecho con el corazón</p>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	 <?php do_action( 'storefront_after_footer' ); ?>
     
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
