<?php
if ( ! defined( 'ABSPATH' ) ) exit();
/**
 * I think this file is not used, and probably should be removed.
 *
 * @package lingotek-translation
 */

// phpcs:disable
require_once 'StandardImportObject.php';

/**
 * This class exists to convert other content (e.g. JSON--Drupal 7, Drupal 8, Middleware--
 * HTML, XML, Text, Plaintext) into content compatible with WP
 *
 * @author Unkown
 * @uses StandardImportObject.php|LingotekStandardImportObject
 * @return LingotekStandardImportObject returns an object that is in the format and has the
 * content to be imported into WordPress
 */
class Lingotek_FormatConverter {
	/**
	 * The document that is used to determine information about the import. It is
	 * the source document that can be accessed.
	 */
	private $source_doc;
	/**
	 * The content is the bulk of the information without format, source, etc. This
	 * is what is converted into the title and body of the wp import.
	 */
	private $content;
	/**
	 * The format is the format of the source upload document so that it can be handled
	 * by the right conversion function (e.g. JSON, HTML, TXT, etc.)
	 */
	private $format;

	/**
	 * Constructor
	 * Sets up the Lingotek_FormatConverter object so it can be converted
	 *
	 * @author Unkown
	 *
	 * @param object $source_doc The document that needs to be converted and then imported
	 * @param string $content The content portion of the document -- This is what becomes
	 *  the body of the WP post/page
	 * @param string $format The format of the file. The extension of the document
	 *  is used to choose the right function to convert to standard
	 * @return void This builds an object that is then converted to wp import
	 */
	function __construct( $source_doc, $content, $format ) {
		$this->source_doc = $source_doc;
		$this->content    = $content;
		$this->format     = $format;
	}


	/**
	 * This function determines which converter function is needed. If there is not
	 * a converter function for the selected document then it defaults to
	 * JSON (in the else statement) and attempts the conversion with the assumption
	 * of working with a JSON file.
	 *
	 * @author Unkown
	 * @return LingotekStandardImportObject $importObject An object that can be imported into WP
	 */
	public function convert_to_standard() {
		if ( method_exists( $this, $this->format . '_to_standard' ) ) {
			$importObject = call_user_func( array( $this, $this->format . '_to_standard' ), $this->source_doc, $this->content );
			return $importObject;
		} else {
			$importObject = call_user_func( array( $this, 'json_to_standard' ), $this->source_doc, $this->content );
			return $importObject;
		}
	}


	/**
	 * Converts source JSON into a LingotekStandardImportObject that can be imported into WP
	 *
	 * @author Unkown
	 * @param object $source_doc source document
	 * @param string $content JSON string that is then parsed to get the relevant
	 * information for the title and body
	 * @return LingotekStandardImportObject That can be imported into WP
	 */
	public function json_to_standard( $source_doc, $content ) {

		/**
		*These string replaces are to make it so that we can access the json objects
		*with these titles. They were being imported with @ before the key and that
		*made them inaccessible. This is specific to Middleware json strings.
	 *
		*@author Matt Smith and TJ Murphy
		*/
		$content = str_replace( '"@title"', '"title"', $content ?? '');
		$content = str_replace( '"@type"', '"type"', $content ?? '');

		$decoded_json = json_decode( $content );

		$content = __(
			'We could not parse the data from this document.
        Are you sure that it is in a recognizable format, such as JSON, XML, HTML, or plain text?',
			'lingotek-translation'
		);
		$title   = __( 'No title found', 'lingotek-translation' );
		$error   = false;

		/**
		*An if statement to check for the different json patterns to find the content
		*that will be the body of the WP imported post/page
	 *
		*@author Unkown and TJ Murphy
		*@return string $content is set -- if nothing matches then $content remains
		*with a warning
		*@see $content
		*/
		// Drupal 7
		if ( isset( $decoded_json->post->post_content ) ) {
			$content = $decoded_json->post->post_content;
		}
		// Drupal 8
		elseif ( isset( $decoded_json->body[0]->value ) ) {
			$content = $decoded_json->body[0]->value;
		} elseif ( isset( $decoded_json->args->description ) ) {
			$content = $decoded_json->args->description;
		}
		// Middleware - MindTouch
		elseif ( isset( $decoded_json->content->body ) ) {
			$content = $decoded_json->content->body;
		}
		// Middleware - Zendesk and HubSpot
		elseif ( isset( $decoded_json->body ) ) {
			$content = $decoded_json->body;
		}
		// Middleware - Email HubSpot
		elseif ( isset( $decoded_json->email_body ) ) {
			$content = $decoded_json->email_body;
		}
		// Middleware
		elseif ( isset( $decoded_json->post_summary ) ) {
			$content = $decoded_json->post_summary;
		}
		// Middleware
		elseif ( isset( $decoded_json->description ) ) {
			$content = $decoded_json->description;
		} else {
			$error = true;
		}

		/**
		*An if statement to check for the different json patterns to find the title
		*that will be the title of the WP imported post/page
	 *
		*@author Unkown and TJ Murphy
		*@return string $title is set -- if nothing matches then $error is set to TRUE
		*@see $title
		*/
		// Drupal 8
		if ( isset( $decoded_json->title[0]->value ) ) {
			$title = $decoded_json->title[0]->value;
		}
		// Drupal 7
		elseif ( isset( $decoded_json->post->post_title ) ) {
			$title = $decoded_json->post->post_title;
		}
		// Middleware - MindTouch
		elseif ( isset( $decoded_json->content->title ) ) {
			$title = $decoded_json->content->title;
		}
		// Middleware - Zendesk and HubSpot
		elseif ( isset( $decoded_json->title ) ) {
			$title = $decoded_json->title;
		}
		// Middleware - Email HubSpot
		elseif ( isset( $decoded_json->name ) ) {
			$title = $decoded_json->name;
		} else {
			$error = true;
		}

		return new LingotekStandardImportObject( $title, $content, $error );
	}

	/**
	 * Converts source XML into a LingotekStandardImportObject that can be imported into WP
	 *
	 * @author Unkown
	 * @param object $source_doc source document
	 * @param string $xml_string XML string that is then parsed to get the relevant
	 * information for the title and body
	 * @return LingotekStandardImportObject That can be imported into WP
	 */
	public function xml_to_standard( $source_doc, $xml_string ) {
		$content           = __(
			'We could not parse the data from this document.
        Are you sure that it is in a recognizable format, such as JSON, XML, HTML, or plain text?',
			'lingotek-translation'
		);
		$title             = __( 'No title found', 'lingotek-translation' );
		$error_message_xml = __( 'Failed to load XML', 'lingotek-translation' );
		$error             = false;
		$xml               = new SimpleXMLElement( $xml_string );
		if ( $xml === false ) {
			echo esc_html( $error_message_xml );
			$error = true;
		}

		$found_content = (array) $xml->xpath( '//element' );
		if ( $found_content ) {
			$content = (string) $found_content[0];
			$title   = (string) $source_doc->properties->title;
		} else {
			$error = true;
		}

		return new LingotekStandardImportObject( $title, $content, $error );
	}

	/**
	 * Converts source TXT into a LingotekStandardImportObject that can be imported into WP
	 *
	 * @author Unkown
	 * @param object $source_doc source document
	 * @param string $content TXT string that is then parsed to get the relevant
	 * information for the title and body
	 * @return LingotekStandardImportObject That can be imported into WP
	 */
	public function txt_to_standard( $source_doc, $content ) {
		$title = $source_doc->properties->title;
		return new LingotekStandardImportObject( $title, $content );
	}

	/**
	 * Converts source PLAINTEXT into a LingotekStandardImportObject that can be imported into WP
	 *
	 * @author Unkown
	 * @param object $source_doc source document
	 * @param string $content PLAINTEXT string that is then parsed to get the relevant
	 * information for the title and body
	 * @return LingotekStandardImportObject That can be imported into WP
	 */
	public function plaintext_to_standard( $source_doc, $content ) {
		$title = $source_doc->properties->title;
		return new LingotekStandardImportObject( $title, $content );
	}

	/**
	 * Converts source HTML into a LingotekStandardImportObject that can be imported into WP
	 *
	 * @author Unkown
	 * @param object $source_doc source document
	 * @param string $content HTML string that is then parsed to get the relevant
	 * information for the title and body
	 * @return LingotekStandardImportObject That can be imported into WP
	 */
	public function html_to_standard( $source_doc, $content ) {
		$title = $source_doc->properties->title;
		return new LingotekStandardImportObject( $title, $content );
	}
}

