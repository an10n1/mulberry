<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'sample_options', 'sample_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Настройки найшей темы', 'sampletheme' ), __( 'Настройки найшей темы', 'sampletheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<h1>Настроки темы</h1>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'sampletheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'sample_options' ); ?>
			<?php $options = get_option( 'sample_theme_options' ); ?>

			<table class="form-table">

				<?php
				/**
				 * A sample text input option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Телефон', 'sampletheme' ); ?></th>
					<td>
						<input id="sample_theme_options[phonetext1]" class="regular-text" type="text" name="sample_theme_options[phonetext1]" value="<?php esc_attr_e( $options['phonetext1'] ); ?>" placeholder="Телефон"/>
						<input id="sample_theme_options[phonetext2]" class="regular-text" type="text" name="sample_theme_options[phonetext2]" value="<?php esc_attr_e( $options['phonetext2'] ); ?>" placeholder="Телефон"/>
						<input id="sample_theme_options[phonetext3]" class="regular-text" type="text" name="sample_theme_options[phonetext3]" value="<?php esc_attr_e( $options['phonetext3'] ); ?>" placeholder="Телефон"/>
					</td>
				</tr>
        <tr valign="top"><th scope="row" style="display: none"><?php _e( 'Дни / Время работы', 'sampletheme' ); ?></th>
          <td>
            <?php if(isset($options['daytext'])):?>
              <input id="sample_theme_options[daytext]" class="regular-text" type="text" name="sample_theme_options[daytext]" value="<?php esc_attr_e( $options['daytext'] ); ?>" placeholder="Дни"/>
            <?php endif; ?>

	          <?php if(isset($options['timetext'])):?>
            <input id="sample_theme_options[timetext]" class="regular-text" type="text" name="sample_theme_options[timetext]" value="<?php esc_attr_e( $options['timetext'] ); ?>" placeholder="Время" />
            <?php endif; ?>
          </td>
        </tr>
				<tr valign="top"><th scope="row"><?php _e( 'Email', 'sampletheme' ); ?></th>
					<td>
						<input id="sample_theme_options[emailtext]" class="regular-text" type="text" name="sample_theme_options[emailtext]" value="<?php esc_attr_e( $options['emailtext'] ); ?>" placeholder="example@site.com"/>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Адрес', 'sampletheme' ); ?></th>
					<td>
						<input id="sample_theme_options[addresstext]" class="regular-text" type="text" name="sample_theme_options[addresstext]" value="<?php esc_attr_e( $options['addresstext'] ); ?>" />
					</td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'sampletheme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
/*function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}*/

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/