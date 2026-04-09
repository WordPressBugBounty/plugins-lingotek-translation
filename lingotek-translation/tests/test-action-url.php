<?php
/**
 * Class ActionUrlTest
 *
 * @package Lingotek_Translation
 */

/**
 * Sample test case.
 */
class ActionUrlTest extends WP_UnitTestCase {

	/**
	 * Tests the rendering of an action url.
	 *
	 * @test
	 * @dataProvider actionsDataProvider
	 *
	 * @param string $url The url.
	 * @param string $title The title.
	 * @param string $expected The expected html.
	 */
	public function SecondaryActionIsRendered( $url, $title, $expected ) {
		$action = new Lingotek_Action_Url( $url, $title );
		$this->assertSame( $url, $action->getUri() );
		$this->assertSame( $title, $action->getTitle() );
		$this->assertXmlStringEqualsXmlString( $expected, $action->render() );
	}

	/**
	 * Data provider for actions.
	 *
	 * @see ::SecondaryActionIsRendered
	 */
	public function actionsDataProvider() {
		yield 'secondary action' => array(
			'https://www.lingotek.com',
			'Lingotek website',
			'<li><a href="https://www.lingotek.com">Lingotek website</a></li>',
		);
	}

}
