<?php
if ( ! defined( 'ABSPATH' ) ) exit();
/**
 * Extends the Polylang class to disable the input fields
 *
 * @since 0.3
 */
class Lingotek_Table_String extends PLL_Table_String {
	/**
	 * Displays the translations to edit (disabled).
	 *
	 * @since 0.3
	 *
	 * @param array $item item.
	 * @return string
	 */
	function column_translations( $item ) {
		$out       = '';
		$lang_names = array();

		if ( is_object( $this->languages ) && method_exists( $this->languages, 'get_list' ) ) {
			foreach ( $this->languages->get_list() as $language ) {
				$lang_names[ $language->slug ] = $language->name;
			}
		} elseif ( is_array( $this->languages ) && isset( $this->languages['languages'] ) ) {
			$lang_names = $this->languages['languages'];
		}

		foreach ( $item['translations'] as $key => $translation ) {
			$input_type = $item['multiline'] ?
				'<textarea name="translation[%1$s][%2$s]" id="%1$s-%2$s" disabled="disabled">%4$s</textarea>' :
				'<input type="text" name="translation[%1$s][%2$s]" id="%1$s-%2$s" value="%4$s" disabled="disabled" />';
			$out       .= sprintf(
				'<div class="translation"><label for="%1$s-%2$s">%3$s</label>' . $input_type . '</div>' . "\n",
				esc_attr( $key ),
				esc_attr( $item['row'] ),
				esc_html( isset( $lang_names[ $key ] ) ? $lang_names[ $key ] : $key ),
				format_to_edit( $translation )
			);
		}
		return $out;
	}

}
