<?php
if ( ! defined( 'ABSPATH' ) ) exit();
/**
 * I think this file is not used, and probably should be removed.
 *
 * @package lingotek-translation
 */

// phpcs:disable

/**
 * Sets all of the setting details so they can appropriately be presented.
 *
 * @author Unknown
 * @var array
 */
$setting_details = array(
	'import_post_status' => array(
		'type'        => 'dropdown',
		'label'       => __( 'Import documents as', 'lingotek-translation' ),
		'description' => __( 'The post status for newly imported documents', 'lingotek-translation' ),
		'values'      => array(
			'draft'   => __( 'Draft', 'lingotek-translation' ),
			'pending' => __( 'Pending Review', 'lingotek-translation' ),
			'publish' => __( 'Published', 'lingotek-translation' ),
			'private' => __( 'Privately Published', 'lingotek-translation' ),
		),
	),
	'import_type'        => array(
		'type'        => 'dropdown',
		'label'       => __( 'Format', 'lingotek-translation' ),
		'description' => __( 'In which format would you like your imports to be?', 'lingotek-translation' ),
		'values'      => array(
			'page' => __( 'Page', 'lingotek-translation' ),
			'post' => __( 'Post', 'lingotek-translation' ),
		),
	),
);


$page_key = $this->plugin_slug . '_import&sm=settings';

/**
 *Sets the options
 *
 *@author Unknown
 */
if ( ! empty( $_POST ) ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'lingotek-translation' ) );
    }
    check_admin_referer( $page_key, '_wpnonce_' . $page_key );
	$options = array();
	foreach ( $setting_details as $key => $setting ) {
		if ( isset( $_POST[ $key ] ) ) {
			$options[ $key ] = $_POST[ $key ];
		} else {
			$options[ $key ] = null;
		}
	}


	update_option( 'lingotek_import_prefs', $options, false );

	add_settings_error( 'lingotek_prefs', 'prefs', __( 'Your preferences were successfully updated.', 'lingotek-translation' ), 'updated' );
	settings_errors();
}
$selected_options = get_option( 'lingotek_import_prefs' );
?>

<h3><?php esc_html_e( 'Settings', 'lingotek-translation' ); ?></h3>

<form id="lingotek-settings" method="post" action="admin.php?page=<?php echo esc_attr( $page_key ); ?>" class="validate">
<?php wp_nonce_field( $page_key, '_wpnonce_' . $page_key ); ?>

  <table class="form-table"><?php foreach ( $setting_details as $key => $setting ) { ?>

	  <tr>
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $setting['label'] ); ?></label></th>
		<td>
		  <?php if ( $setting['type'] == 'dropdown' ) { ?>
		  <select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>">
				<?php
				foreach ( $setting['values'] as $id => $title ) {
					echo "\n\t" . '<option value="' . esc_attr( $id ) . '" ' . selected( $selected_options[ $key ], $id ) . '>' . esc_html( $title ) . '</option>';
				}
				?>
			</select>
				<?php
		  } elseif ( $setting['type'] == 'checkboxes' ) {
			  echo '<ul class="pref-statuses">';
			  foreach ( $setting['values'] as $id => $title ) {
				  $cb_name = $key . '[' . esc_attr( $id ) . ']';
				  $checked = checked( '1', ( isset( $selected_options[ $key ][ $id ] ) && $selected_options[ $key ][ $id ] ), false );
				  echo '<li><input type="checkbox" id="' . esc_attr( $cb_name ) . '" name="' . esc_attr( $cb_name ) . '" value="1" ' . $checked . '><label for="' . esc_attr( $cb_name ) . '">' . esc_html( $title ) . '</label></li>';
			  }
			  echo '</ul>';
		  }
			?>
		  <p class="description">
			<?php echo esc_html( $setting['description'] ); ?>
		  </p>
	  </tr>
		<?php
							}//end foreach
							?>
  </table>

<?php submit_button( __( 'Save Changes', 'lingotek-translation' ), 'primary', 'submit', false ); ?>
</form>
