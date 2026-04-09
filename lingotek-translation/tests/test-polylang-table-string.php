<?php
/**
 * Regression tests for Lingotek_Table_String Polylang compatibility.
 *
 * Verifies that column_translations works with both the old array-based
 * and modern object-based Languages model introduced in Polylang 3.8.
 *
 * @package Lingotek_Translation
 */

class PolylangTableStringTest extends WP_UnitTestCase {

	/**
	 * column_translations must render language labels from the modern
	 * Polylang Languages model object.
	 *
	 * @test
	 */
	public function column_translations_handles_modern_languages_model() {
		if ( ! class_exists( 'PLL_Table_String' ) || ! class_exists( 'Lingotek_Table_String' ) ) {
			$this->markTestSkipped( 'PLL_Table_String or Lingotek_Table_String not available.' );
		}

		if ( ! isset( $GLOBALS['polylang'] ) || ! isset( PLL()->model->languages ) ) {
			$this->markTestSkipped( 'Polylang languages model not available.' );
		}

		$languages = PLL()->model->get_languages_list();
		if ( empty( $languages ) ) {
			$this->markTestSkipped( 'No Polylang languages configured.' );
		}

		$language = reset( $languages );
		$table    = new Lingotek_Table_String( PLL()->model->languages );
		$output   = $table->column_translations(
			array(
				'translations' => array(
					$language->slug => 'Bonjour',
				),
				'multiline'    => false,
				'row'          => 1,
			)
		);

		$this->assertIsString( $output );
		$this->assertStringContainsString( esc_html( $language->name ), $output );
		$this->assertStringContainsString( 'Bonjour', $output );
	}

	/**
	 * prepare_items must delegate to the current Polylang implementation
	 * using the modern Languages object and populate table items.
	 *
	 * @test
	 */
	public function prepare_items_uses_current_polylang_table_implementation() {
		if ( ! class_exists( 'PLL_Table_String' ) || ! class_exists( 'Lingotek_Table_String' ) ) {
			$this->markTestSkipped( 'PLL_Table_String or Lingotek_Table_String not available.' );
		}

		if ( ! isset( $GLOBALS['polylang'] ) || ! isset( PLL()->model->languages ) ) {
			$this->markTestSkipped( 'Polylang languages model not available.' );
		}

		$table = new Lingotek_Table_String( PLL()->model->languages );
		$table->prepare_items();

		$method = new ReflectionMethod( 'Lingotek_Table_String', 'prepare_items' );
		$this->assertSame( 'PLL_Table_String', $method->getDeclaringClass()->getName() );
		$this->assertIsArray( $table->items );
	}

	/**
	 * Lingotek_Model constructor must not fatal when $GLOBALS['polylang']
	 * is not yet initialized (early load path).
	 *
	 * @test
	 */
	public function lingotek_model_constructor_degrades_gracefully_without_polylang() {
		if ( ! class_exists( 'Lingotek_Model' ) ) {
			$this->markTestSkipped( 'Lingotek_Model not available.' );
		}

		$saved = isset( $GLOBALS['polylang'] ) ? $GLOBALS['polylang'] : null;
		unset( $GLOBALS['polylang'] );

		$model = new Lingotek_Model();
		$this->assertNull(
			$model->pllm,
			'pllm must be null when Polylang is not available.'
		);

		if ( null !== $saved ) {
			$GLOBALS['polylang'] = $saved;
		}
	}
}
