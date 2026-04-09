<?php
/**
 * Regression tests: Polylang parent/child method signature compatibility.
 *
 * Uses PHP Reflection to verify that every overridden method in Lingotek
 * admin classes declares the same parameter types and return types as the
 * Polylang parent it extends. A mismatch here means a PHP 8 fatal.
 *
 * @package Lingotek_Translation
 */

class PolylangSignatureCompatTest extends WP_UnitTestCase {

	/**
	 * Verify Polylang is available in the test environment.
	 *
	 * @test
	 */
	public function polylang_is_loaded_in_test_environment() {
		$this->assertTrue(
			class_exists( 'PLL_Admin_Filters_Columns' ),
			'Polylang must be loaded for signature-compat tests to be meaningful.'
		);
	}

	/**
	 * @test
	 * @dataProvider signaturePairsProvider
	 *
	 * @param string $parent_class  Fully-qualified parent class name.
	 * @param string $child_class   Fully-qualified child class name.
	 * @param string $method        Method name to compare.
	 */
	public function child_method_signature_matches_parent( $parent_class, $child_class, $method ) {
		if ( ! class_exists( $parent_class ) || ! class_exists( $child_class ) ) {
			$this->markTestSkipped( "Skipping: $parent_class or $child_class not available." );
		}

		$parent_ref = new ReflectionMethod( $parent_class, $method );
		$child_ref  = new ReflectionMethod( $child_class, $method );

		$this->assertSame(
			(string) $parent_ref->getReturnType(),
			(string) $child_ref->getReturnType(),
			"Return type of $child_class::$method must match $parent_class::$method"
		);

		$parent_params = $parent_ref->getParameters();
		$child_params  = $child_ref->getParameters();

		$this->assertSame(
			count( $parent_params ),
			count( $child_params ),
			"Parameter count of $child_class::$method must match $parent_class::$method"
		);

		foreach ( $parent_params as $i => $parent_param ) {
			$parent_type = (string) $parent_param->getType();
			$child_type  = (string) $child_params[ $i ]->getType();
			if ( '' === $parent_type ) {
				continue;
			}
			$this->assertSame(
				$parent_type,
				$child_type,
				"Parameter #{$i} type of $child_class::$method must match $parent_class::$method"
			);
		}
	}

	/**
	 * Provides parent/child/method triples for signature comparison.
	 *
	 * @return Generator
	 */
	public function signaturePairsProvider() {
		yield 'add_column' => array(
			'PLL_Admin_Filters_Columns',
			'Lingotek_Filters_Columns',
			'add_column',
		);

		yield 'post_column' => array(
			'PLL_Admin_Filters_Columns',
			'Lingotek_Filters_Columns',
			'post_column',
		);

		yield 'save_post' => array(
			'PLL_CRUD_Posts',
			'Lingotek_Filters_Post',
			'save_post',
		);

		yield 'save_term' => array(
			'PLL_Admin_Filters_Term',
			'Lingotek_Filters_Term',
			'save_term',
		);

		yield 'column_translations' => array(
			'PLL_Table_String',
			'Lingotek_Table_String',
			'column_translations',
		);

		yield 'prepare_items' => array(
			'PLL_Table_String',
			'Lingotek_Table_String',
			'prepare_items',
		);

		yield 'process_posts' => array(
			'PLL_WP_Import',
			'Lingotek_WP_Import',
			'process_posts',
		);
	}
}
