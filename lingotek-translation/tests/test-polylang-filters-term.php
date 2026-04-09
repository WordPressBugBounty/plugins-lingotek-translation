<?php
/**
 * Regression tests for Lingotek_Filters_Term compatibility behavior.
 *
 * @package Lingotek_Translation
 */

class Lingotek_Filters_Term_Document_Fake {
	public $pre_save_terms_calls = array();

	public function pre_save_terms( $term_id, $taxonomy, $language ) {
		$this->pre_save_terms_calls[] = array(
			'term_id'  => $term_id,
			'taxonomy' => $taxonomy,
			'language' => $language,
		);
	}
}

class Lingotek_Filters_Term_Lgtm_Fake {
	public $document;
	public $upload_calls = array();
	public $can_upload   = true;

	public function __construct( $document ) {
		$this->document = $document;
	}

	public function get_group( $type, $term_id ) {
		return $this->document;
	}

	public function can_upload( $type, $term_id ) {
		return $this->can_upload;
	}

	public function upload_term( $term_id, $taxonomy ) {
		$this->upload_calls[] = array(
			'term_id'  => $term_id,
			'taxonomy' => $taxonomy,
		);
	}
}

class Lingotek_Filters_Term_Test_Double extends Lingotek_Filters_Term {
	public $force_import_request   = false;
	public $force_should_autoupload = false;
	public $saved_parent_calls     = array();

	public function __construct() {}

	protected function is_import_request() {
		return $this->force_import_request;
	}

	protected function save_parent_term( $term_id, $tt_id, $taxonomy ) {
		$this->saved_parent_calls[] = array(
			'term_id'  => $term_id,
			'tt_id'    => $tt_id,
			'taxonomy' => $taxonomy,
		);
	}

	protected function should_auto_upload_term( $taxonomy, $term_id ) {
		return $this->force_should_autoupload;
	}
}

class PolylangFiltersTermTest extends WP_UnitTestCase {
	private function set_object_property( $object, $property_name, $value ) {
		$reflection = new ReflectionClass( $object );

		while ( $reflection ) {
			if ( $reflection->hasProperty( $property_name ) ) {
				$property = $reflection->getProperty( $property_name );
				$property->setAccessible( true );
				$property->setValue( $object, $value );
				return;
			}
			$reflection = $reflection->getParentClass();
		}

		$this->fail( "Property {$property_name} was not found." );
	}

	private function create_translated_category_term() {
		if ( ! isset( $GLOBALS['polylang'] ) ) {
			$this->markTestSkipped( 'Polylang global not initialized.' );
		}

		$languages = PLL()->model->get_languages_list();
		if ( empty( $languages ) ) {
			$this->markTestSkipped( 'No Polylang languages configured.' );
		}

		$language = reset( $languages );
		$term_id  = self::factory()->term->create(
			array(
				'taxonomy' => 'category',
				'name'     => 'Lingotek term ' . wp_generate_password( 8, false ),
			)
		);

		PLL()->model->term->set_language( $term_id, $language );

		return array( $term_id, $language );
	}

	/**
	 * @test
	 */
	public function save_term_skips_parent_save_and_upload_during_import_requests() {
		list( $term_id ) = $this->create_translated_category_term();

		$document = new Lingotek_Filters_Term_Document_Fake();
		$lgtm     = new Lingotek_Filters_Term_Lgtm_Fake( $document );
		$subject  = new Lingotek_Filters_Term_Test_Double();

		$this->set_object_property( $subject, 'model', PLL()->model );
		$subject->lgtm                   = $lgtm;
		$subject->force_import_request   = true;
		$subject->force_should_autoupload = true;

		$subject->save_term( $term_id, 0, 'category' );

		$this->assertCount( 1, $document->pre_save_terms_calls );
		$this->assertSame( array(), $subject->saved_parent_calls );
		$this->assertSame( array(), $lgtm->upload_calls );
	}

	/**
	 * @test
	 */
	public function save_term_calls_parent_save_and_upload_when_not_importing() {
		list( $term_id ) = $this->create_translated_category_term();

		$document = new Lingotek_Filters_Term_Document_Fake();
		$lgtm     = new Lingotek_Filters_Term_Lgtm_Fake( $document );
		$subject  = new Lingotek_Filters_Term_Test_Double();

		$this->set_object_property( $subject, 'model', PLL()->model );
		$subject->lgtm                   = $lgtm;
		$subject->force_import_request   = false;
		$subject->force_should_autoupload = true;

		$subject->save_term( $term_id, 0, 'category' );

		$this->assertCount( 1, $document->pre_save_terms_calls );
		$this->assertCount( 1, $subject->saved_parent_calls );
		$this->assertCount( 1, $lgtm->upload_calls );
		$this->assertSame( $term_id, $lgtm->upload_calls[0]['term_id'] );
		$this->assertSame( 'category', $lgtm->upload_calls[0]['taxonomy'] );
	}
}
