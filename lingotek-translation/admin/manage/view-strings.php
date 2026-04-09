<?php
if ( ! defined( 'ABSPATH' ) ) exit();
?>
<h3 style="padding-top:10px; margin-top:10px; margin-bottom:-25px;"><?php esc_html_e( 'Strings', 'lingotek-translation' ); ?> <a href="admin.php?page=mlang_strings" title="<?php esc_attr_e( 'Edit on Polylang Strings Translation page', 'lingotek-translation' ); ?>" class="dashicons dashicons-edit"></a></h3>

<?php
$string_table = new Lingotek_Table_String( PLL()->model->languages );
$string_table->prepare_items();
?>

<div class="form-wrap">
	<form id="string-translation" method="post" action="admin.php?page=mlang_strings&amp;noheader=true">
		<input type="hidden" name="pll_action" value="string-translation" />
		<?php
		$string_table->search_box( __( 'Search translations', 'lingotek-translation' ), 'translations' );
		wp_nonce_field( 'string-translation', '_wpnonce_string-translation' );
		$string_table->display();
		?>
	</form>
</div>
