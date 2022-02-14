<?php
/**
 * If you want create Custom Gutenberg block.
 */

function register_custom_blocks() {
	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
		$acf_render_callback = 'acf_block_render_callback';

		// register a slider block
		acf_register_block(
			array(
				'name'				=> 'slider',
				'title'				=> __('Visionneuse'),
				'description'		=> __('Add a custom slider'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'images-alt',
			)
		);

		// register a accordion block
		acf_register_block(
			array(
				'name'				=> 'accordion',
				'title'				=> __('Accordéon'),
				'description'		=> __('Add a custom accordion'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'list-view',
			)
		);
	}
}

/**
 *  This is the callback that displays the block.
 *
 * @param   array  $block      The block settings and attributes.
 * @param   string $content    The block content (emtpy string).
 * @param   bool   $is_preview True during AJAX preview.
 */
function acf_block_render_callback( $block, $content = '', $is_preview = false ) {
	$context = Timber::context();
	$context['block'] = $block;
	$context['fields'] = get_fields();
	$context['is_preview'] = $is_preview;
	$slug = str_replace( 'acf/', '', $block['name'] );

	Timber::render( '/views/blocks/content-' . $slug . '.twig', $context );
}
