<?php

	add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );
	 
	function override_woocommerce_widgets() {
	 
		/* Best sellers */

		if ( class_exists( 'WC_Widget_Best_Sellers' ) ) {
			unregister_widget( 'WC_Widget_Best_Sellers' );
			include_once( 'widgets/widget-best-sellers.php' );
			register_widget( 'Custom_WC_Widget_Best_Sellers' );
		}
	 
		/* Featured products */

		if ( class_exists( 'WC_Widget_Featured_Products' ) ) {
			unregister_widget( 'WC_Widget_Featured_Products' );
			include_once( 'widgets/widget-featured-products.php' );
			register_widget( 'Custom_WC_Widget_Featured_Products' );
		}

		/* Random products */

		if ( class_exists( 'WC_Widget_Random_Products' ) ) {
			unregister_widget( 'WC_Widget_Random_Products' );
			include_once( 'widgets/widget-random-products.php' );
			register_widget( 'Custom_WC_Widget_Random_Products' );
		}

		/* Recently view products */

		if ( class_exists( 'WC_Widget_Recently_Viewed' ) ) {
			unregister_widget( 'WC_Widget_Recently_Viewed' );
			include_once( 'widgets/widget-recently-viewed.php' );
			register_widget( 'Custom_WC_Widget_Recently_Viewed' );
		}

		/* Recently added products */

		if ( class_exists( 'WC_Widget_Recent_Products' ) ) {
			unregister_widget( 'WC_Widget_Recent_Products' );
			include_once( 'widgets/widget-recent-products.php' );
			register_widget( 'Custom_WC_Widget_Recent_Products' );
		}

		/* Top rated products */

		if ( class_exists( 'WC_Widget_Top_Rated_Products' ) ) {
			unregister_widget( 'WC_Widget_Top_Rated_Products' );
			include_once( 'widgets/widget-top-rated-products.php' );
			register_widget( 'Custom_WC_Widget_Top_Rated_Products' );
		}

		/* Products */

		if ( class_exists( 'WC_Widget_Products' ) ) {
			unregister_widget( 'WC_Widget_Products' );
			include_once( 'widgets/widget-products.php' );
			register_widget( 'Custom_WC_Widget_Products' );
		}

		/* Recent Reviews */

		if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
			unregister_widget( 'WC_Widget_Recent_Reviews' );
			include_once( 'widgets/widget-recent-reviews.php' );
			register_widget( 'Custom_WC_Widget_Recent_Reviews' );
		}

	}

	/* Number of upsells */

	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
		function woocommerce_output_upsells() {
		    woocommerce_upsell_display( 5,5 );
		}
	}

	/* Producsts per page */

	global $anps_shop_data;

	if( isset($anps_shop_data['shop_per_page']) ) {
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . $anps_shop_data['shop_per_page'] . ';' ), 20 );
	}

?>