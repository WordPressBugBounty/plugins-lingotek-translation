<?php
if ( ! defined( 'ABSPATH' ) ) exit();
/**
 * I think this file is not used, and probably should be removed.
 *
 * @package lingotek-translation
 */

// phpcs:disable
?>
<div class="wrap">
	<h2><?php esc_html_e( 'Import', 'lingotek-translation' ); ?></h2>
	<p class="description"><?php printf( esc_html__( 'Import your posts from another WordPress blog through Lingotek', 'lingotek-translation' ), esc_url( 'admin.php?page=lingotek-translation_import' ) ); ?></p>


	<?php
	$menu_items = array(
		'content'  => __( 'Content', 'lingotek-translation' ),
		'settings' => __( 'Settings', 'lingotek-translation' ),
	);
	?>

	<h3 class="nav-tab-wrapper">
	  <?php
		$menu_item_index = 0;
		foreach ( $menu_items as $menu_item_key => $menu_item_label ) {
			$use_as_default = ( $menu_item_index === 0 && ! isset( $_GET['sm'] ) ) ? true : false;
			$alias          = null;
			$sm = isset( $_GET['sm'] ) ? sanitize_text_field( $_GET['sm'] ) : '';
			// custom sub sub-menus
			if ( $sm == 'edit-profile' ) {
				$alias = 'profiles';
			}
			$menu_item_key_sanitized = sanitize_text_field( $menu_item_key );
			?>

			<a class="nav-tab
				<?php
				if ( $use_as_default || ( $sm  === $menu_item_key_sanitized ) || $alias == $menu_item_key_sanitized) :
				?>
			 		nav-tab-active<?php endif; ?>"
		   		href="admin.php?page=<?php echo esc_attr( sanitize_text_field( $_GET['page'] ) ); ?>&amp;sm=<?php echo esc_attr( $menu_item_key_sanitized ); ?>">
				<?php echo esc_attr( sanitize_text_field( $menu_item_label ) ); ?>
			</a>
			<?php
			 $menu_item_index++;
		}
		?>
	</h3>

	<?php
	settings_errors();
	$submenu  = isset( $_GET['sm'] ) ? sanitize_text_field( $_GET['sm'] ) : 'content';
	$dir      = dirname( __FILE__ ) . '/import/';
	$filename = $dir . 'view-' . $submenu . '.php';
	if ( file_exists( $filename ) ) {
		require $filename;
	} else {
		echo 'TO-DO: create <i>' . esc_html( 'import/view-' . $submenu . '.php' ) . '</i>';
	}
	?>

</div>
