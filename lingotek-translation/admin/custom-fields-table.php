<?php
if ( ! defined( 'ABSPATH' ) ) exit();
if ( ! class_exists( 'WP_List_Table' ) ) {
	// Since WP 3.1.
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Lingotek Custom Fields Table class.
 */
class Lingotek_Custom_Fields_Table extends WP_List_Table {
	/**
	 * List of custom fields to display, excluding hidden-copy fields.
	 *
	 * @var array
	 */
	private $custom_fields;
	/**
	 * List of custom fields.
	 *
	 * @var array
	 */
	private $custom_field_choices;

	/**
	 * Constructor
	 *
	 * @since 0.2
	 *
	 * @param array $custom_fields custom fields to display.
	 * @param array $custom_field_choices raw custom fields.
	 */
	public function __construct( $custom_fields, $custom_field_choices ) {
		$this->custom_fields        = $custom_fields;
		$this->custom_field_choices = $custom_field_choices;
		parent::__construct(
			array(
				// Do not translate (used for css class).
				'plural' => 'lingotek-custom-fields',
				'ajax'   => false,
			)
		);
	}

	/**
	 * Gets the custom fields to display
	 *
	 * @since 1.5.5
	 *
	 * @param string $search Search term to filter out the list.
	 * @return array
	 */
	public function get_custom_fields( $search = '' ) {
		if ( ! isset( $this->custom_fields ) || ! empty( $search ) ) {
			$this->custom_fields = Lingotek_Group_Post::get_cached_meta_values( $search );
		}
		return $this->custom_fields;
	}
	/**
	 * Displays the item's meta_key
	 *
	 * @since 0.2
	 *
	 * @param array $item item.
	 * @return string
	 */
	protected function column_meta_key( $item ) {
		return isset( $item['meta_key'] ) ? esc_html( $item['meta_key'] ) : '';
	}

	/**
	 * Displays the item setting
	 *
	 * @since 0.2
	 *
	 * @param array $item item.
	 */
	protected function column_setting( $item ) {
		$settings = array( 'translate', 'copy', 'ignore' );
		printf( '<select class="custom-field-setting" name="%1$s" id="%1$s" onchange="this.form.submit()">', 'settings[' . esc_html( $item['meta_key'] ) . ']' );

		// select the option from the lingotek_custom_fields option.
		foreach ( $settings as $setting ) {
			if ( $setting === $this->custom_field_choices[ $item['meta_key'] ] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo "\n\t<option value='" . esc_attr( $setting ) . "' " . esc_html( $selected ) . '>' . esc_attr( ucwords( $setting ) ) . '</option>';
		}
		echo '</select>';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_columns() {
		return array(
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'cb'       => '<input type="checkbox" />',
			'meta_key' => __( 'Custom Field Key', 'lingotek-translation' ),
			'setting'  => __( 'Action', 'lingotek-translation' ),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_sortable_columns() {
		return array(
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_key' => array( 'meta_key', false ),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function prepare_items() {
		if ( isset( $_REQUEST['page'] ) && isset( $_REQUEST['s'] ) ) {
			$this->custom_fields = $this->get_custom_fields( sanitize_text_field( $_REQUEST['s'] ) );
		} else {
				$this->custom_fields = $this->get_custom_fields();
		}
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		// No sort by default.
		if ( ! empty( $orderby ) ) {
			usort( $this->custom_fields, 'usort_reorder' );
		}

		/* pagination */
		$per_page            = 25;
		$total_items         = count( $this->custom_fields );
		$current_page        = $this->get_pagenum();
		$this->custom_fields = array_slice( $this->custom_fields, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);

		$this->items = $this->custom_fields;
	}

	/**
	 * Custom sorting comparator.
	 *
	 * @param  array $a array of strings.
	 * @param  array $b array of strings.
	 * @return int sort direction.
	 */
	public function usort_reorder( $a, $b ) {
		$order   = sanitize_text_field( filter_input(INPUT_GET, 'order') );
        $orderby = sanitize_text_field( filter_input(INPUT_GET, 'orderby') );
		// Determine sort order.
		$result = strcmp( $a[ $orderby ], $b[ $orderby ] );
		// Send final sort direction to usort.
		return ( empty( $order ) || 'asc' === $order ) ? $result : -$result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" class="boxes" name="%s" value="%s" > ',
			esc_html( $item['meta_key'] ),
			esc_html( $item['setting'] )
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_bulk_actions() {
		$actions = array(
			'ignore'    => 'Ignore',
			'translate' => 'Translate',
			'copy'      => 'Copy',
		);
		return $actions;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function pagination( $which ) { if ( empty( $this->_pagination_args ) ) { return; }

    $total_items     = $this->_pagination_args['total_items'];
    $total_pages     = $this->_pagination_args['total_pages'];
    $infinite_scroll = false;

    if ( isset( $this->_pagination_args['infinite_scroll'] ) ) {
        $infinite_scroll = $this->_pagination_args['infinite_scroll'];
    }

    if ( 'top' === $which && $total_pages > 1 ) {
        $this->screen->render_screen_reader_content( 'heading_pagination' );
    }

    $output = '<span class="displaying-num">' . sprintf( esc_html( _n( '%s item', '%s items', $total_items ) ), esc_html( number_format_i18n( $total_items ) ) ) . '</span>';

    $current              = $this->get_pagenum();
    $removable_query_args = wp_removable_query_args();

    $current_url = esc_url( set_url_scheme( 'http://' . sanitize_text_field( $_SERVER['HTTP_HOST'] ) . filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL) ) );

    $current_url = remove_query_arg( $removable_query_args, $current_url );

    if( isset($_REQUEST['s'] ) ){
        $current_url = add_query_arg( 's', sanitize_text_field($_REQUEST['s']), $current_url );
    }

    $page_links = array();

    $total_pages_before = '<span class="paging-input">';
    $total_pages_after  = '</span></span>';

    $disable_first = $disable_last = $disable_prev = $disable_next = false;

    if ( $current == 1 ) {
        $disable_first = true;
        $disable_prev  = true;
    }
    if ( $current == 2 ) {
        $disable_first = true;
    }
    if ( $current == $total_pages ) {
        $disable_last = true;
        $disable_next = true;
    }
    if ( $current == $total_pages - 1 ) {
        $disable_last = true;
    }

    if ( $disable_first ) {
        $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>';
    } else {
        $page_links[] = sprintf(
            "<a class='first-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
            esc_url( remove_query_arg( 'paged', $current_url ) ),
            __( 'First page' ),
            '&laquo;'
        );
    }

    if ( $disable_prev ) {
        $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>';
    } else {
        $page_links[] = sprintf(
            "<a class='prev-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
            esc_url( add_query_arg( 'paged', max( 1, $current - 1 ), $current_url ) ),
            __( 'Previous page' ),
            '&lsaquo;'
        );
    }

    if ( 'bottom' === $which ) {
        $html_current_page  = $current;
        $total_pages_before = '<span class="screen-reader-text">' . __( 'Current Page' ) . '</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">';
    } else {
        $html_current_page = sprintf(
            "%s<input class='current-page' id='current-page-selector' type='text' name='paged' value='%s' size='%d' aria-describedby='table-paging' /><span class='tablenav-paging-text'>",
            '<label for="current-page-selector" class="screen-reader-text">' . __( 'Current Page' ) . '</label>',
            $current,
            strlen( $total_pages )
        );
    }
    $html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
    $page_links[]     = $total_pages_before . sprintf( _x( '%1$s of %2$s', 'paging', 'lingotek-translation' ), $html_current_page, $html_total_pages ) . $total_pages_after;

    if ( $disable_next ) {
        $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&rsaquo;</span>';
    } else {
        $page_links[] = sprintf(
            "<a class='next-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
            esc_url( add_query_arg( 'paged', min( $total_pages, $current + 1 ), $current_url ) ),
            __( 'Next page' ),
            '&rsaquo;'
        );
    }

    if ( $disable_last ) {
        $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&raquo;</span>';
    } else {
        $page_links[] = sprintf(
            "<a class='last-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
            esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
            __( 'Last page' ),
            '&raquo;'
        );
    }

    $pagination_links_class = 'pagination-links';
    if ( ! empty( $infinite_scroll ) ) {
        $pagination_links_class .= ' hide-if-js';
    }
    $output .= "\n<span class='$pagination_links_class'>" . join( "\n", $page_links ) . '</span>';

    if ( $total_pages ) {
        $page_class = $total_pages < 2 ? ' one-page' : '';
    } else {
        $page_class = ' no-pages';
    }

    $this->_pagination = "<div class='tablenav-pages{$page_class}'>" . wp_kses_post( $output ) . "</div>";
    echo $this->_pagination;
}
}
