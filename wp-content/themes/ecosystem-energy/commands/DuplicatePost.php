<?php
class DuplicatePost {
	/**
	 * Duplicates a post
	 *
	 * ## OPTIONS
	 *
	 * <id>
	 * : The id of the post.
	 *
	 * <count>
	 * : The number of duplicates we want.
	 *
	 * [--same_title=<type>]
	 * : Whether or not to keep the same title, if set to false, the number of the iteration will be added
	 * ---
	 * default: 0
	 * options:
	 *   - 1
	 *   - 0
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp duplicate_post 185 10
	 *
	 * @when after_wp_load
	 */
	public function __invoke( $args, $assoc_args ) {
		list( $id, $count ) = $args;
		$this->duplicate_post( $id, $count, (bool) $assoc_args['same_title'] );
		WP_CLI::success( 'Post dupliqué !' );
	}

	private function duplicate_post( int $id, int $count, bool $title = true ) {
		$post = get_post( $id );
		$metas = get_post_meta( $id );
		$post_data = [
			'post_author' => $post->post_author,
			'post_title' => $post->post_title,
			'post_type' => $post->post_type,
			'post_content' => $post->post_content,
			'post_status' => $post->post_status,
		];
		for ( $i = 1; $i <= $count; $i++ ) {
			WP_CLI::log( ' ' );
			WP_CLI::log( '-- Import n°' . $i );
			if ( $title === false ) {
				$post_data['post_title'] = $post->post_title . ' ' . $i;
			}
			WP_CLI::log( 'Name: ' . $post_data['post_title'] );
			$new_post = wp_insert_post( $post_data );
			foreach ( $metas as $meta_key => $meta_value ) {
				WP_CLI::log( $meta_key . ': ' . $meta_value[0] );
				add_post_meta( $new_post, $meta_key, $meta_value[0] );
			}
		}
	}
}
