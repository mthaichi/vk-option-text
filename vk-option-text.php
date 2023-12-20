<?php
/**
 * Plugin Name:       Vk Option Text
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       vk-option-text
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function vk_option_text_vk_option_text_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'vk_option_text_vk_option_text_block_init' );

add_action('admin_menu', 'vk_option_text_menu');

function vk_option_text_menu() {
    add_options_page('VK Option Text Settings', 'VK Option Text', 'manage_options', 'vk-option-text', 'vk_option_text_settings_page');
}
function vk_option_text_settings_page() {
    // 既存のオプション値を取得
    $options = get_option('vk_option_text_settings');
    ?>
    <div class="wrap">
    <h2>VK Option Text Settings</h2>
    <form method="post" action="options.php">
        <?php settings_fields('vk-option-text-settings-group'); ?>
        <?php do_settings_sections('vk-option-text-settings-group'); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">VK Option Text 1</th>
            <td><input type="text" name="vk_option_text_settings[vk_option_text_1]" value="<?php echo esc_attr($options['vk_option_text_1']); ?>" /></td>
            </tr>
             
            <tr valign="top">
            <th scope="row">VK Option Text 2</th>
            <td><input type="text" name="vk_option_text_settings[vk_option_text_2]" value="<?php echo esc_attr($options['vk_option_text_2']); ?>" /></td>
            </tr>
            
            <tr valign="top">
            <th scope="row">VK Option Text 3</th>
            <td><input type="text" name="vk_option_text_settings[vk_option_text_3]" value="<?php echo esc_attr($options['vk_option_text_3']); ?>" /></td>
            </tr>

            <tr valign="top">
            <th scope="row">VK Option Text 4</th>
            <td><input type="text" name="vk_option_text_settings[vk_option_text_4]" value="<?php echo esc_attr($options['vk_option_text_4']); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>

    </form>
    </div>
    <?php
}

function vk_sanitaize_options( $options ) {
	return $options;
}

add_action('admin_init', 'vk_option_text_settings');

function vk_option_text_settings() {
    register_setting('vk-option-text-settings-group', 'vk_option_text_settings',
	array(
		'type'              => 'object',
		'sanitize_callback' => 'vk_sanitaize_options',
		'show_in_rest'      => array(
			'schema' => array(
				'type'       => 'object',
				'properties' => array(
					'vk_option_text_1'        => array(
						'type' => 'string',
					),
					'vk_option_text_2'        => array(
						'type' => 'string',
					),		
					'vk_option_text_3'        => array(
						'type' => 'string',
					),	
					'vk_option_text_4'        => array(
						'type' => 'string',
					)												
			)
		)
	)));
}

add_action( 'rest_api_init', 'vk_option_text_rest_api_init' );

function vk_option_text_rest_api_init() {
	register_rest_route(
		'vk-option-text/v2',
		'/settings',
		array(
			array(
				'methods'             => 'GET',
				'callback'            => 'get_vk_option_tests',
		
			),
			array(
				'methods'             => 'POST',
				'callback'            => 'update_vk_option_tests',

			)
		)
	);
}

function get_vk_option_tests() {
	$options = get_option('vk_option_text_settings');
	return rest_ensure_response( $options );
}

/**
 * VK Blocks Rest Update Callback
 *
 * @param object $request — .
 * @return \WP_REST_Response|\WP_Error
 */
function update_vk_option_tests( $request ) {
	$json_params = $request->get_json_params();
	update_option( 'vk_option_text_settings', $json_params );
	return rest_ensure_response(
		array(
			'success' => true,
		)
	);
}