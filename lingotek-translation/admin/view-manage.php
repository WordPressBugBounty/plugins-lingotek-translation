<?php
if ( ! defined( 'ABSPATH' ) ) exit();
?>
<div class="wrap">
  <h2><?php esc_html_e( 'Manage', 'lingotek-translation' ); ?></h2>

	<?php

	$menu_items = array(
		'content'       => __( 'Content Type Configuration', 'lingotek-translation' ),
		'profiles'      => __( 'Translation Profiles', 'lingotek-translation' ),
		'custom-fields' => __( 'Custom Fields', 'lingotek-translation' ),
		'string-groups' => __( 'String Groups', 'lingotek-translation' ),
		'strings'       => __( 'Strings', 'lingotek-translation' ),
	);

	?>

	<h3 class="nav-tab-wrapper">
	  <?php
		$menu_item_index = 0;
		foreach ( $menu_items as $menu_item_key => $menu_item_label ) {
			$sm = isset( $_GET['sm'] ) ? sanitize_text_field( $_GET['sm'] ) : '';
			$menu_item_key_sanitized = sanitize_text_field( $menu_item_key );
			$use_as_default = ( $menu_item_index === 0 && ! isset( $_GET['sm'] ) ) ? true : false;
			?>

		<a class="nav-tab
			<?php
			if ( $use_as_default || ( $sm == $menu_item_key_sanitized ) ) :
				?>
			 nav-tab-active<?php endif; ?>"
		   href="admin.php?page=<?php echo esc_attr( sanitize_text_field( $_GET['page'] ) ); ?>&amp;sm=<?php echo esc_attr( $menu_item_key_sanitized ); ?>">
		   	<?php echo esc_attr( sanitize_text_field( $menu_item_label ) ); ?></a>
		<?php
			 $menu_item_index++;
		}
		?>
	</h3>

	<?php
	settings_errors();
	$allowed_menu_items = array_keys( $menu_items );
	$submenu  = isset( $_GET['sm'] ) ? sanitize_text_field( $_GET['sm'] ) : current( $allowed_menu_items );
	$dir      = dirname( __FILE__ ) . '/manage/';
	$filename = $dir . 'view-' . $submenu . '.php';
	if ( in_array( $submenu, $allowed_menu_items, true ) && file_exists( $filename ) ) {
		require $filename;
	} else {
		echo 'TO-DO: create <i>' . esc_html( 'manage/view-' . $submenu . '.php' ) . '</i>';
	}
	?>

</div>

<script>jQuery(document).ready(function($) { $('#wpfooter').remove(); } );</script>
