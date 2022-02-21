<?php
/**
 * If you want create Custom Gutenberg block.
 */

function register_custom_blocks() {
	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
		$acf_render_callback = 'acf_block_render_callback';

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

		// register colored text bloc
		acf_register_block(
			array(
				'name'				=> 'button',
				'title'				=> __('Button'),
				'description'		=> __('Add a custom button'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'list-view',
			)
		);

		// register colored text bloc
		acf_register_block(
			array(
				'name'				=> 'color-block',
				'title'				=> __('Color block'),
				'description'		=> __('Add a custom colored block'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'list-view',
			)
		);

		// register cta block with image/title/text/link
		acf_register_block(
			array(
				'name'				=> 'cta-block',
				'title'				=> __('CTA block'),
				'description'		=> __('Add a custom CTA block'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'list-view',
			)
		);

		// register key data value bloc
		acf_register_block(
			array(
				'name'				=> 'key-data',
				'title'				=> __('Key data'),
				'description'		=> __('Add a custom data block'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'list-view',
			)
		);

		// register colored text bloc
		acf_register_block(
			array(
				'name'				=> 'link',
				'title'				=> __('Link'),
				'description'		=> __('Add a custom link'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'list-view',
			)
		);

		// register a slider block
		acf_register_block(
			array(
				'name'				=> 'slider',
				'title'				=> __('Slider - single'),
				'description'		=> __('Add a full-size slider with 1 image at a time'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'images-alt',
			)
		);

		// register a slider block with multiple visible slides
		acf_register_block(
			array(
				'name'				=> 'slider-multiple',
				'title'				=> __('Slider - multiple'),
				'description'		=> __('Add a slider with multiple columns'),
				'render_callback'	=> $acf_render_callback,
				'category'			=> 'formatting',
				'icon'				=> 'images-alt',
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
