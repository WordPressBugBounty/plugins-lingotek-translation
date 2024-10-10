<?php
if ( ! defined( 'ABSPATH' ) ) exit();
  $menu_items = array(
	  'features' => __( 'Features', 'lingotek-translation' ),
	  'content'  => __( 'Tutorial', 'lingotek-translation' ),
	  'faq'      => __( 'FAQ', 'lingotek-translation' ),
	  'credits'  => __( 'Credits', 'lingotek-translation' ),
  );

	?>


<div class="wrap about-wrap">

    <h1><?php printf( esc_html_e( 'Welcome to Ray Enterprise', 'lingotek-translation' ) ); ?></h1>

<div class="about-text"><?php printf( esc_html__( 'Thank you for updating! Ray Enterprise offers convenient cloud-based localization and translation.', 'lingotek-translation' ), esc_html( LINGOTEK_VERSION ) ); ?></div>


<div class="wp-badge" style="background: url(<?php echo esc_url( LINGOTEK_URL ); ?>/img/rayEnterpriseIcon.svg) center 24px/85px 80px no-repeat #fff; color: #666;"><?php printf( esc_html__( 'Version %s', 'lingotek-translation' ), esc_html( LINGOTEK_VERSION ) ); ?></div>

<h2 class="nav-tab-wrapper">
  <?php
	$menu_item_index = 0;
	foreach ( $menu_items as $menu_item_key => $menu_item_label ) {
		$use_as_default = ( $menu_item_index === 0 && ! isset( $_GET['sm'] ) ) ? true : false;
		$sm = isset( $_GET['sm'] ) ? sanitize_text_field( $_GET['sm'] ) : '';
		$menu_item_key_sanitized = sanitize_text_field( $menu_item_key );
		$menu_item_label_sanitized = sanitize_text_field( $menu_item_label );
		?>

	<a class="nav-tab 
		<?php
		if ( $use_as_default || ( $sm == $$menu_item_key_sanitized ) ) :
			?>
		 nav-tab-active<?php endif; ?>"
	   href="admin.php?page=<?php echo esc_attr( sanitize_text_field( $_GET['page'] ) ); ?>&sm=<?php echo esc_attr( $menu_item_key_sanitized ); ?>">
	   <?php echo esc_attr( $menu_item_label_sanitized ); ?></a>
		<?php
		 $menu_item_index++;
	}
	?>
</h2>


<?php
	settings_errors();
	$submenu  = isset( $_GET['sm'] ) ? sanitize_text_field( $_GET['sm'] ) : current( array_keys( $menu_items ) );
	$dir      = dirname( __FILE__ ) . '/tutorial/';
	$filename = $dir . $submenu . '.php';
if ( file_exists( $filename ) ) {
	require $filename;
} else {
	echo 'TO-DO: create <i>' . esc_html( 'tutorial/' . $submenu . '.php' ) . '</i>';
}
?>

</div>
