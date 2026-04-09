<?php
/**
 * Behavioral regression tests for Lingotek_Filters_Columns.
 *
 * Verifies that the overridden column methods preserve the parent
 * contract expected by Polylang and WordPress list-table rendering.
 *
 * @package Lingotek_Translation
 */

class PolylangAdminColumnsTest extends WP_UnitTestCase {

	/**
	 * add_column must return an array containing Lingotek columns
	 * without corrupting inherited columns.
	 *
	 * @test
	 */
	public function add_column_returns_array_with_lingotek_columns() {
		if ( ! class_exists( 'Lingotek_Filters_Columns' ) ) {
			$this->markTestSkipped( 'Lingotek_Filters_Columns not available.' );
		}

		$user_id = self::factory()->user->create();
		wp_set_current_user( $user_id );

		$ref = new ReflectionMethod( 'Lingotek_Filters_Columns', 'add_column' );
		$ref->setAccessible( true );

		$polylang = isset( $GLOBALS['polylang'] ) ? $GLOBALS['polylang'] : null;
		if ( ! $polylang ) {
			$this->markTestSkipped( 'Polylang global not initialized.' );
		}

		$instance = new Lingotek_Filters_Columns( $polylang );
		$columns  = array(
			'cb'    => '<input type="checkbox" />',
			'title' => 'Title',
			'date'  => 'Date',
		);

		$result = $ref->invoke( $instance, $columns, 'date' );

		$this->assertIsArray( $result, 'add_column must return an array.' );
		$this->assertArrayHasKey( 'lingotek_source', $result );
		$this->assertArrayHasKey( 'lingotek_targets', $result );
		$this->assertArrayHasKey( 'cb', $result, 'Pre-existing columns must be preserved.' );
		$this->assertArrayHasKey( 'title', $result, 'Pre-existing columns must be preserved.' );
		$this->assertArrayHasKey( 'date', $result, 'Columns after $before must be preserved.' );

		$languages = PLL()->model->get_languages_list();
		if ( empty( $languages ) ) {
			$this->markTestSkipped( 'No Polylang languages configured.' );
		}

		$language = reset( $languages );
		$this->assertArrayHasKey(
			'language_' . $language->slug,
			$result,
			'Language columns must use Polylang slugs.'
		);

		if ( $language->locale !== $language->slug ) {
			$this->assertArrayNotHasKey(
				'language_' . $language->locale,
				$result,
				'Language columns must not use Polylang locales.'
			);
		}

		$post_hidden_columns = get_user_meta( $user_id, 'manageedit-postcolumnshidden', true );
		$page_hidden_columns = get_user_meta( $user_id, 'manageedit-pagecolumnshidden', true );

		$this->assertIsArray( $post_hidden_columns );
		$this->assertIsArray( $page_hidden_columns );
		$this->assertContains( 'language_' . $language->slug, $post_hidden_columns );
		$this->assertContains( 'language_' . $language->slug, $page_hidden_columns );
	}

	/**
	 * term_column must return $custom_data for non-language columns
	 * instead of returning null.
	 *
	 * @test
	 */
	public function term_column_returns_custom_data_for_non_language_column() {
		if ( ! class_exists( 'Lingotek_Filters_Columns' ) ) {
			$this->markTestSkipped( 'Lingotek_Filters_Columns not available.' );
		}

		$polylang = isset( $GLOBALS['polylang'] ) ? $GLOBALS['polylang'] : null;
		if ( ! $polylang ) {
			$this->markTestSkipped( 'Polylang global not initialized.' );
		}

		$instance = new Lingotek_Filters_Columns( $polylang );

		$result = $instance->term_column( 'existing_data', 'name', 1 );
		$this->assertSame(
			'existing_data',
			$result,
			'term_column must pass through $custom_data for non-language columns.'
		);
	}
}
