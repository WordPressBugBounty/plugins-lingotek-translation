<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package Lingotek_Translation
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( "{$_tests_dir}/includes/functions.php" ) ) {
	echo "Could not find {$_tests_dir}/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL;
	exit( 1 );
}

require_once "{$_tests_dir}/includes/functions.php";

/**
 * Manually load Polylang and the plugin being tested.
 */
function _manually_load_plugin() {
	$polylang_dir = getenv( 'POLYLANG_DIR' );

	if ( ! $polylang_dir ) {
		$polylang_dir = WP_PLUGIN_DIR . '/polylang';
	}

	if ( file_exists( $polylang_dir . '/polylang.php' ) ) {
		require_once $polylang_dir . '/polylang.php';
	}

	require dirname( dirname( __FILE__ ) ) . '/lingotek.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array( 'polylang/polylang.php', 'lingotek-translation/lingotek.php' ),
);

require "{$_tests_dir}/includes/bootstrap.php";

