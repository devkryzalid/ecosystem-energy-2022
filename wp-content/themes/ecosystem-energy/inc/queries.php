<?php
/**
 * Allows us to perform a query both on title and metas
 * This functions adds a filter on hook get_meta_sql, which is used by wp_query when meta_query argument is present;
 * And adds sql to it in order to search also in title
 */
function meta_or_title( $q ) {
	if ( ! empty( $q->get( '_meta_or_title' ) ) ) {
		$title = $q->get( '_meta_or_title' );
		add_filter(
			'get_meta_sql',
			function( $sql ) use ( $title ) {
				global $wpdb;

				// Only run once:
				static $nr = 0; 
				if ( 0 !== $nr++ ) {
					return $sql;
				}

				// Modified WHERE
				$sql['where'] = sprintf(
					' AND ( %s OR %s ) ',
					$wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title ),
					mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
				);

				return $sql;
			}
		);
	}
}

