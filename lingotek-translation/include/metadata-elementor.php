<?php
if ( ! defined( 'ABSPATH' ) ) exit();
/**
 * Special processing for Elementor metadata content
 *
 * @since 1.5.3
 */
class Lingotek_Metadata_Elementor {
	/**
	 * Reusable variable of elementor data meta key
	 *
	 * @var string
	 */
	public static $elementor_data = '_elementor_data';

	/**
	 * Reusable variable of elementor edit mode meta key. Determines if the elementor data should be applied to the post.
	 *
	 * @var string
	 */
	public static $elementor_edit_mode = '_elementor_edit_mode';

	/**
	 * Reusable variable of Lingotek custom field for Elementor field group
	 *
	 * @var string
	 */
	public static $elementor_content = 'elementor_content';

	/**
	 * Widgets that contain translatable content.
	 *
	 * @var array
	 */
	protected static $text_widgets = array(
		'text-editor'       => array(
			'editor',
		),
		'heading'           => array(
			'title',
		),
		'button'            => array(
			'text',
		),
		'call-to-action'    => array(
			'title',
			'description',
			'button',
		),
		'form'              => array(
			'form_name',
			'form_fields',
			'step_next_label',
			'step_previous_label',
			'button_text',
			'success_message',
			'error_message',
			'required_field_message',
			'invalid_message',
		),
		'text-path'         => array(),
		'blockquote'        => array(),
		'forms'             => array(),
		'animated-headline' => array(),
		'price-list'        => array(),
		'price-table'       => array(),
		'table-of-contents' => array(),
		'lottie'            => array(),
		'theme-site-title'  => array(),
		'icon-list'         => array(
			'title',
			'text',
			'description',
			'description_text',
			'title_text',
			'custom_text',
		),
		'icon-box'          => array(
			'title',
			'text',
			'description',
			'description_text',
			'title_text',
			
		),
		'slides'          => array(
			'heading',
			'description',
			'button_text',
			'description_text',
			'title_text',
			'title',
			'text',
		),
		'post-info'         => array(
			'title',
			'text',
			'description',
			'description_text',
			'title_text',
			'custom_text',
		),
		'title',
		'text',
		'description',
		'description_text',
		'title_text',
		'editor',
		'custom_text',
		
	);

	/**
	 * Settings to translate in field forms
	 *
	 * @var array
	 */
	public static $translatable_form_fields = array(
		'field_label',
		'placeholder',
		'previous_button',
		'next_button',
		'acceptance_text',
		'field_value',
		'field_options',
		'field_html',
	);


	/**
	 * Widgets that embedded content that need to be handled differently, i.e. images
	 * The values are the translatable fields in the settings of each widget type.
	 *
	 * @var array
	 */
	public static $embedded_widgets = array(
		'image'                => array(
			'caption',
			'alt',
		),
		'image-box'            => array(
			'title_text',
			'description_text',
		),
		'hotspot'              => array(
			'hotspot',
			'hotspot_label',
			'hotspot_tooltip_content',
		),
		'testimonial-carousel' => array(
			'slides',
			'content',
			'name',
			'title',
		),
		'blockquote'           => array(
			'blockquote_content',
			'tweet_button_label',
			'author_name',
		),
		'posts'                => array(
			'classic_meta_separator',
			'classic_read_more_text',
			'cards_meta_separator',
			'cards_read_more_text',
			'full_content_meta_separator',
			'pagination_prev_label',
			'pagination_next_label',
			'text',
			'load_more_no_posts_custom_message',
		),
		'gallery'              => array(
			'gallery_title',
			'show_all_galleries_label',
		),
		'author-box'            => array(
			'author_name',
			'author_bio',
			'link_text',
		),
	);

	/**
	 * Get the translatable content from the _elementor_data
	 *
	 * @since 1.5.3
	 *
	 * @param array $post_meta_array The post meta array.
	 * @param array $post_and_template_meta_array The merged array of the post meta and the template meta.
	 * @return array list of translatable content, where the indexes are the element ids, and the values are the element content
	 */
	public static function get_post_metadata_content( $post_meta_array, $post_and_template_meta_array ) {
		$content_list = array();

		if ( empty($post_and_template_meta_array) ) {
			self::get_elements( $post_meta_array, $content_list );
		} else {
			self::get_elements( $post_and_template_meta_array, $content_list );
		}

		return $content_list;
	}

	/**
	 * Sets the translated content into the copied _elementor_data json string
	 *
	 * @since 1.5.3
	 *
	 * @param int    $post_id The translated post id.
	 * @param string $element_json The original json string.
	 * @param array  $translation_list The list of translated content.
	 * @return boolean True if the content in the original json string is successfully replaced with the translated content, and the meta field for the translated post is successfully updated, false otherwise.
	 */
	public static function set_post_metadata_content( $post_id, $element_json, $translation_list ) {
		// We need to set the translations in the meta string from the original post
		$meta_array = json_decode( $element_json, true );
		if ( ! $meta_array && ! $translation_list ) {
			// We either don't have the original json string or there is no translated content.
			return false;
		}
		self::set_translations( $meta_array, $translation_list );
		$updated_meta_json_string = wp_slash( wp_json_encode( $meta_array ) );
		return update_post_meta( $post_id, self::$elementor_data, $updated_meta_json_string );
	}

	/**
	 * Parse through the list of elements and pull translatable elements into a list
	 *
	 * @since 1.5.3
	 *
	 * @param array $element_list List of elementor elements.
	 * @param array $content_list List of translatable elements.
	 */
	public static function get_elements( $element_list, &$content_list ) {
		foreach ( $element_list as $element ) {
			$element_in_array    = isset( $element['id'], $content_list[ $element['id'] ] ) ? true : false;
			$element_settings    = isset( $element['settings'] ) && ! empty( $element['settings'] ) ? $element['settings'] : false;
			$element_widget_type = isset( $element['widgetType'] ) ? $element['widgetType'] : false;

			// Check if element has already been stored, and if the widget has translatable text.
			$widget_editor_type  = $element_widget_type && array_key_exists( $element_widget_type, self::$text_widgets ) ? true : false;
			$embedded_widget    = isset( self::$embedded_widgets[ $element_widget_type ] ) ? true : false;
			if ( ! $element_in_array && $widget_editor_type && $element_settings ) {
				$translatable_fields = self::$text_widgets[ $element_widget_type ];
				if ( ! empty( $translatable_fields ) ) {
					foreach ( $translatable_fields as $field ) {
						if ( 'form_fields' === $field ) {
							$content_list[ $element['id'] ][ $field ] = self::get_form_fields( $element_settings[ $field ] );
						} elseif ( 'slides' === $element_widget_type ) {
							foreach ( $element_settings['slides'] as $index => $slide ) {
								if ( ! isset( $content_list[ $element['id'] ]['slides'][ $index ] ) ) {
									$content_list[ $element['id'] ]['slides'][ $index ] = array();
								}
								$content_list[ $element['id'] ]['slides'][ $index ][ $field ] = $slide[ $field ];
							}
						} elseif ( 'icon-list' === $element_widget_type || 'post-info' === $element_widget_type ) {
							foreach ( $element_settings['icon_list'] as $index => $icon_list ) {
								if ( ! isset( $content_list[ $element['id'] ]['icon_list'][ $index ] ) ) {
									$content_list[ $element['id'] ]['icon_list'][ $index ] = array();
								}
								$content_list[ $element['id'] ]['icon_list'][ $index ][ $field ] = $icon_list[ $field ];
							}
						} else {
							$content_list[ $element['id'] ][ $field ] = $element_settings[ $field ];
						}
					}
				} else {
					$content_list[ $element['id'] ] = $element_settings;
				}
			} elseif ( ! $element_in_array && $embedded_widget && $element_settings && is_array( $element_settings ) ) {
				$translatable_fields            = isset( self::$embedded_widgets[ $element_widget_type ] ) ? self::$embedded_widgets[ $element_widget_type ] : array();
				$content_list[ $element['id'] ] = self::get_translatable_fields( $translatable_fields, $element_settings );
			}
			$sub_elements = isset( $element['elements'] ) && ! empty( $element['elements'] ) ? $element['elements'] : false;
			if ( $sub_elements ) {
				// Check embedded elements for more translatable content.
				self::get_elements( $sub_elements, $content_list );
			}
		}
	}

	/**
	 * Sets the translated content in the elementor elements in for the translated post
	 *
	 * @since 1.5.3
	 *
	 * @param array $element_list List of elementor elements.
	 * @param array $translation_list List of translated content.
	 */
	public static function set_translations( &$element_list, $translation_list ) {
		foreach ( $element_list as $key => $element ) {
			$translated_element  = isset( $element['id'], $translation_list[ $element['id'] ] ) ? $translation_list[ $element['id'] ] : false;
			$element_settings    = isset( $element['settings'] ) && ! empty( $element['settings'] ) ? $element['settings'] : false;
			$element_widget_type = isset( $element['widgetType'] ) ? $element['widgetType'] : false;
			$widget_editor_type  = $element_widget_type && array_key_exists( $element_widget_type, self::$text_widgets ) ? true : false;
			$embedded_widget     = isset( self::$embedded_widgets[ $element_widget_type ] ) ? true : false;
			// Check that element translation exists, has a valid editor type, and has a settings key.
			if ( $translated_element && $widget_editor_type && $element_settings ) {
				$translatable_fields = self::$text_widgets[ $element_widget_type ];
				if ( ! empty( $translatable_fields ) ) {
					foreach ( $translatable_fields as $field ) {
						if ( 'form_fields' === $field ) {
							$element['settings'][ $field ] = self::set_form_fields( $element['settings'][ $field ], $translated_element[ $field ] );
						} else if ( 'slides' === $element_widget_type ) {
							foreach ( $element_settings['slides'] as $index => $slide ) {
								$element['settings']['slides'][ $index ][ $field ] = $translated_element['slides'][$index][ $field ];
							}
						} elseif ( 'icon-list' === $element_widget_type || 'post-info' === $element_widget_type  ) {
							foreach ( $element_settings['icon_list'] as $index => $icon_list ) {
								$element['settings']['icon_list'][ $index ][ $field ] = $translated_element['icon_list'][$index][ $field ];
							}
						} else {
							$element['settings'][ $field ] = $translated_element[ $field ];
						}
					}
				} else {
					$element['settings'] = $translated_element;
				}
			} elseif ( $translated_element && $element_settings && $embedded_widget ) {
				$translatable_fields = isset( self::$embedded_widgets[ $element_widget_type ] ) ? self::$embedded_widgets[ $element_widget_type ] : array();
				$element['settings'] = self::set_translatable_fields( $translatable_fields, $element_settings, $translated_element );
			}
			$sub_elements = isset( $element['elements'] ) && ! empty( $element['elements'] ) ? $element['elements'] : false;
			if ( $sub_elements ) {
				// Check if any embedded elements have translations and update them.
				self::set_translations( $sub_elements, $translation_list );
				$element['elements'] = $sub_elements;
			}
			// Save element to list of elements, along with any changes.
			$element_list[ $key ] = $element;
		}
	}

	/**
	 * Gets the translatable fields from embedded content.
	 *
	 * @since 1.5.3
	 *
	 * @param array $translatable_fields Array containing the fields that we want to translate.
	 * @param array $settings Array containing the current widget settings.
	 * @return array
	 */
	public static function get_translatable_fields( $translatable_fields, $settings ) {
		$temp_settings = array();
		// we only want to translate specific fields, anything not translatable has its key prepended with `_`
		foreach ( $settings as $setting => $value ) {
			// if an image exists within a widget setting, we only want to translate the alt text.
			if ( 'image' === $setting && is_array( $value ) ) {
				$temp_settings[ $setting ] = self::get_translatable_fields( array( 'alt' ), $value );
			} elseif ( in_array( $setting, $translatable_fields, true ) ) {
				// If setting is a translatable field then we save it as is.
				if ( is_array( $value ) && ! self::has_string_keys( $value ) ) {
					// If the field is a JSON array and not a JSON object, we go through each item to check that it is translatable.
					foreach ( $value as $value_key => $value_settings ) {
						$value[ $value_key ] = self::get_translatable_fields( $translatable_fields, $value_settings );
					}
				}
				$temp_settings[ $setting ] = $value;
			} else {
				// Non translatable fields are prepended with `_` to mark them as non translatable.
				// If the setting is not translatable, but if it is an array, we check if it's a JSON object, or a JSON array.
				if ( is_array( $value ) ) {
					$temp_value      = array();
					$has_string_keys = self::has_string_keys( $value );
					foreach ( $value as $value_key => $value_settings ) {
						// If it's a JSON object then we check if any of its fields are translatable.
						if ( $has_string_keys ) {
							if ( in_array( $value_key, $translatable_fields, true ) ) {
								$temp_value[ $value_key ] = $value_settings;
							} else {
								$temp_value[ '_' . $value_key ] = $value_settings;
							}
						} elseif ( is_array( $value_settings ) ) {
							// Else we check each item in the array for translatable fields.
							$temp_value[ $value_key ] = self::get_translatable_fields( $translatable_fields, $value_settings );
						}
					}
					// We save any changes made to the field value.
					$value = $temp_value;
				}
				$temp_settings[ '_' . $setting ] = $value;
			}//end if
		}//end foreach
		return $temp_settings;
	}

	/**
	 * Sets the translations back in the correct translatable fields
	 *
	 * @since 1.5.3
	 *
	 * @param array $translatable_fields Array of translatable fields for current element type.
	 * @param array $settings Array of the current element settings.
	 * @param array $translation Translated version of the current element settings.
	 * @return array Return the current element settings with the correct translations properly inserted.
	 */
	public static function set_translatable_fields( $translatable_fields, $settings, $translation ) {
		foreach ( $translation as $key => $value ) {
			// Images are a special case since we only want to translate the alt text, and this is shorter than adding 'alt'
			// and 'image' to all the content that potentially uses images in their widget
			if ( 'image' === $key && is_array( $value ) ) {
				$settings[ $key ] = self::set_translatable_fields( array( 'alt' ), $settings[ $key ], $value );
				continue;
			}
			// If the key is a string and not a translatable field, we assume that an underscore was added to mark it as non-translatable, so it's removed.
			if ( ! in_array( $key, $translatable_fields, true ) && is_string( $key ) ) {
				$temp_key = substr( $key, 1 );
			} else {
				$temp_key = $key;
			}
			// If the current translated value is an array then we have to update each of its
			// fields individually incase not all of them are translatable.
			if ( is_array( $value ) ) {
				$value = self::set_translatable_fields( $translatable_fields, $settings[ $temp_key ], $value );
			}
			// Replace current setting value with translated value.
			$settings[ $temp_key ] = $value;
		}//end foreach
		return $settings;
	}

	/**
	 * Gets the form_field settings for translation
	 *
	 * @since 1.5.6
	 * @param array $form_fields List of fields found in the form widget.
	 * @return array
	 */
	public static function get_form_fields( array $form_fields ) {
		$element_form_fields = array();
		foreach ( $form_fields as $key => $form_field_settings ) {
			$translatable_form_field_settings = array();
			foreach ( self::$translatable_form_fields as $translatable_field ) {
				$translatable_form_field_settings[ $translatable_field ] = $form_field_settings[ $translatable_field ];
			}
			$element_form_fields[ $key ] = $translatable_form_field_settings;
		}
		return $element_form_fields;
	}

	/**
	 * Sets the translated from_field settings
	 *
	 * @since 1.5.6
	 * @param array $form_fields List of fields found in forms.
	 * @param array $translated_form_fields List of localized fields.
	 * @return array
	 */
	public static function set_form_fields( array $form_fields, array $translated_form_fields ) {
		foreach ( $form_fields as $key => $form_field_settings ) {
			$form_field_settings['placeholder'] = $translated_form_fields[ $key ]['placeholder'];
			$form_field_settings['field_label'] = $translated_form_fields[ $key ]['field_label'];
			$form_fields[ $key ]                = $form_field_settings;
		}
		return $form_fields;
	}

	/**
	 * Returns true if the array has all string keys, else returns false
	 *
	 * @since 1.5.3
	 *
	 * @param array $array Array to test.
	 * @return boolean
	 */
	public static function has_string_keys( array $array ) {
		return count( array_filter( array_keys( $array ), 'is_string' ) ) > 0;
	}

	/**
	 * Get the merged array of the post and template meta
	 *
	 * @since 1.5.3
	 *
	 * @param array $post_meta_array The post meta array.
	 * @return array $post_and_template_meta_array The merged array of the post meta and the template meta.
	 */
	public static function get_merged_post_and_template_meta( $post_meta_array ) {
		$post_and_template_meta_array = array();

		$template_id = null;
		$template_meta_array = array();

		// Traverse the array to find the template_id
		foreach ( $post_meta_array as $element_key => $element ) {
			if ( isset( $element['elements'] ) ) {
				foreach ( $element['elements'] as $sub_element ) {
					if ( isset( $sub_element['settings']['template_id'] ) ) {
						$template_id = $sub_element['settings']['template_id'];
						// If template_id is found, fetch the post meta using the template_id
						if ( $template_id ) {
							unset( $post_meta_array[ $element_key ] );

							$template_meta_json_string = get_post_meta( $template_id, Lingotek_Metadata_Elementor::$elementor_data, true );

							$template_meta_array_temp = json_decode( $template_meta_json_string, true );

							$template_meta_array = array_merge( $template_meta_array, $template_meta_array_temp );

						}
					}
				}
			}
		}

		if ( $template_id ) {
			$post_and_template_meta_array = array_merge( $post_and_template_meta_array, $post_meta_array );
			$post_and_template_meta_array = array_merge( $post_and_template_meta_array, $template_meta_array );
		}

		return $post_and_template_meta_array;
	}
}
