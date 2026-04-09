<?php
/**
 * Class LingotekInstallationTest
 *
 * @package Lingotek_Translation
 */

/**
 * Sample test case.
 */
class LingotekInstallationTest extends WP_UnitTestCase {

	/**
	 * Tests the initial options are set on activation.
	 *
	 * @test
	 * @dataProvider getInitialOptions
	 *
	 * @param string $option The option name.
	 * @param mixed  $value The expected value.
	 */
	public function InitialOptionsAreSet( $option, $value ) {
		$this->ltk = new Lingotek();
		$this->ltk->activate();

		$this->assertSame( $value, get_option( $option ) );
	}

	/**
	 * Tests the initial profiles are created on activation.
	 *
	 * @test
	 */
	public function InitialProfilesAreCreated() {
		$this->ltk = new Lingotek();
		$this->ltk->activate();

		$profiles = get_option( 'lingotek_profiles', false );

		$this->assertEquals( 3, count( $profiles ) );
		$this->assertTrue( isset( $profiles['automatic'] ) );
		$this->assertTrue( isset( $profiles['manual'] ) );
		$this->assertTrue( isset( $profiles['disabled'] ) );
	}

	/**
	 * Data provider for initial options values.
	 *
	 * @see ::InitialOptionsAreSet
	 */
	public function getInitialOptions() {
		yield 'lingotek_plugin_version' => array( 'lingotek_plugin_version', LINGOTEK_VERSION );
		yield 'lingotek_profiles' => array(
			'lingotek_profiles',
			array(
				'automatic' => array(
					'profile'  => 'automatic',
					'name'     => 'Automatic',
					'upload'   => 'automatic',
					'download' => 'automatic',
				),
				'manual'    => array(
					'profile'  => 'manual',
					'name'     => 'Manual',
					'upload'   => 'manual',
					'download' => 'manual',
				),
				'disabled'  => array(
					'profile' => 'disabled',
					'name'    => 'Disabled',
				),
			),
		);
	}

	/**
	 * Helper function for outputting data while running tests (debug purposes).
	 *
	 * @param mixed $data The data to be logged.
	 */
	public function log( $data ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export,WordPress.WP.AlternativeFunctions.file_system_read_fwrite
		fwrite( STDERR, var_export( $data, true ) );
	}

}
