<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */

function search_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( $query->is_search ) {
			$query->set( 'paged', ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1 );
			$query->set( 'posts_per_page', 12 );
		}
	}
}
