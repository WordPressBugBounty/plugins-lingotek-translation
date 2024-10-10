<?php
if ( ! defined( 'ABSPATH' ) ) exit();

global $polylang;

$settings = array(
	'ignore'    => 'Ignore',
	'translate' => 'Translate',
	'copy'      => 'Copy',
);

$default_custom_fields = '';

/**
 * Custom fields formatted to avoid displaying hidden-copy fields
 *
 * @var array
 */
$cached_custom_fields = Lingotek_Group_Post::get_cached_meta_values();

/**
 * All custom fields
 *
 * @var array
 */
$custom_field_choices = get_option( 'lingotek_custom_fields', array() );

if ( ! empty( $_POST ) ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'lingotek-translation' ) );
    }
	check_admin_referer( 'lingotek-custom-fields', '_wpnonce_lingotek-custom-fields' );
	$action =  isset($_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : '';
	$action2 = isset($_POST['action2'] ) ? sanitize_text_field( $_POST['action2'] ) : '';

	if ( isset( $_POST['default_custom_fields'] ) ) {
		// Set default setting for new custom fields
		$default_custom_fields = sanitize_text_field( $_POST['default_custom_fields'] );
		update_option( 'lingotek_default_custom_fields', $default_custom_fields, false );
		add_settings_error( 'lingotek_custom_fields_default_save', 'custom_fields', __( 'Your <i> Default Custom Fields </i> setting was successfully saved.', 'lingotek-translation' ), 'updated' );
	} elseif ( ! empty( $_POST['refresh'] ) ) {
		// Refresh custom fields
		Lingotek_Group_Post::get_updated_meta_values();
		add_settings_error( 'lingotek_custom_fields_refresh', 'custom_fields', __( 'Your <i>Custom Fields</i> were sucessfully identified.', 'lingotek-translation' ), 'updated' );
	} elseif ( (array_key_exists( $action , $settings ) || array_key_exists( $action2 , $settings ) ) ) {
		// Bulk Change
		// if action exists in settings, use its value. if not, check if action2 exists in settings, use its value. return false if neither exists.
		$action3 = array_key_exists( $action , $settings ) ? $action : ( array_key_exists( $action2 , $settings ) ? $action2 : false );
		foreach ( $_POST as $post => $value ) {
			if ( $action && array_key_exists( $post, $custom_field_choices ) ) {
				$custom_field_choices[ $post ] = $action3;
			}
		}
		update_option( 'lingotek_custom_fields', $custom_field_choices, false );
		add_settings_error( 'lingotek_custom_fields_save', 'custom_fields', __( 'Your <i>Bulk Custom Field Changes</i> were sucessfully saved.', 'lingotek-translation' ), 'updated' );
	} elseif ( ! empty( $_POST['settings'] ) ) {
		// Single field change.
		$arr = empty( $_POST['settings'] ) ? array() : $_POST['settings'];
		foreach ( $arr as $key => $value ) {
			$key = sanitize_key( $key );
        	$value = sanitize_text_field( $value );
			if ( array_key_exists( $key, $custom_field_choices ) ) {
				$custom_field_choices[ $key ] = $value;
			}
		}
		update_option( 'lingotek_custom_fields', $custom_field_choices, false );
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			$cache_key = 'content_type_fields_' . $post_type;
			wp_cache_delete( $cache_key, 'lingotek' );
		}
		add_settings_error( 'lingotek_custom_fields_save', 'custom_fields', __( 'Your <i>Custom Field</i> was sucessfully saved.', 'lingotek-translation' ), 'updated' );
	}//end if
	settings_errors();
}//end if

$default_custom_fields = get_option( 'lingotek_default_custom_fields' );

?>

<h3><?php esc_html_e( 'Custom Field Configuration', 'lingotek-translation' ); ?></h3>
<p class="description">
	<?php esc_html_e( 'Custom Fields can be translated, copied, or ignored. Click "Refresh Custom Fields" to identify and enable your custom fields.', 'lingotek-translation' ); ?>
</p>
<form method="post" action="admin.php?page=lingotek-translation_manage&amp;sm=custom-fields" class="validate">
<?php
	wp_nonce_field( 'lingotek-custom-fields', '_wpnonce_lingotek-custom-fields' );
?>

	<br>
	<label for="default_custom_fields">Default configuration for new Custom Fields</label>
	<select name="default_custom_fields" onchange="this.form.submit()">
	<?php
	foreach ( $settings as $key => $title ) {
		$selected = $key == $default_custom_fields ? 'selected="selected"' : '';
		echo "\n\t<option value='" . esc_attr( $key ) . "' " . esc_attr( $selected ) . ">" . esc_attr( $title ) . '</option>';
	}
	?>
	</select>
</form>
</br>
<?php
	$table = new Lingotek_Custom_Fields_Table( $cached_custom_fields, $custom_field_choices );
	$table->prepare_items();
?>
<form method="post">
	<?php wp_nonce_field( 'lingotek-custom-fields', '_wpnonce_lingotek-custom-fields' ); ?>
	<input type="hidden" name="page" value="lingotek_custom_fields_table">
	<?php $table->search_box( 'search', 'search_id' ); ?>
	<?php $table->display(); ?>
</form>
</br>
<div id="lingotek_submit_actions" style="display: flex;flex-direction: row;justify-content: flex-start;column-gap: 1em;">
	<form method="post" action="admin.php?page=lingotek-translation_manage&amp;sm=custom-fields" class="validate" id="refresh_fields">
		<?php
		wp_nonce_field( 'lingotek-custom-fields', '_wpnonce_lingotek-custom-fields' );
		submit_button( __( 'Refresh Custom Fields', 'lingotek-translation' ), 'secondary', 'refresh', false, array( 'form' => 'refresh_fields' ) );
		?>
	</form>
</div>


<?php
echo "
<script>

function show(source){
  var ids = document.getElementsByClassName('boxes');
  for ( var i in ids) {
      if (ids[i].checked == true || source.checked == true ) {
        document.getElementById('d1').style.display='block';   
        break;    
      }
      else{
        document.getElementById('d1').style.display='none';     
  }  
}
 
}
var selectedIds = [];
function toggle(source) {
  document.getElementById('d1').style.display='block';
  if(source.checked == false){
    document.getElementById('d1').style.display='none';
  }


    checkboxes = document.getElementsByClassName('boxes');
    for ( var i in checkboxes)
        checkboxes[i].checked = source.checked;
}

</script>" ?>
