<?php
if ( ! defined( 'ABSPATH' ) ) exit();
global $polylang;

$profiles = Lingotek::get_profiles();
$profiles = $this->get_profiles_usage( $profiles );
$settings = $this->get_profiles_settings();

if ( isset( $_GET['lingotek_action'] ) && 'delete-profile' == sanitize_text_field( $_GET['lingotek_action'] ) ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'lingotek-translation' ) );
    }
	check_admin_referer( 'delete-profile' );

	// check again that usage empty
	if ( ! empty( $profiles[ $_GET['profile'] ] ) && empty( $profiles[ $_GET['profile'] ]['usage'] ) ) {
		unset( $profiles[ $_GET['profile'] ] );
		update_option( 'lingotek_profiles', $profiles, false );
		add_settings_error( 'lingotek_profile', 'default', __( 'Your translation profile was sucessfully deleted.', 'lingotek-translation' ), 'updated' );
		set_transient( 'settings_errors', get_settings_errors(), 30 );
		wp_redirect( admin_url( 'admin.php?page=lingotek-translation_manage&sm=profiles&settings-updated=1' ) );
		exit;
	}
}

if ( ! empty( $_POST ) ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'lingotek-translation' ) );
    }
	check_admin_referer( 'lingotek-edit-profile', '_wpnonce_lingotek-edit-profile' );

	$defaults = get_option( 'lingotek_defaults', array() );

	if ( empty( $_POST['name'] ) && empty( $_POST['profile'] ) ) {
		add_settings_error( 'lingotek_profile', 'default', __( 'You must provide a name for your translation profile.', 'lingotek-translation' ), 'error' );
	} else {
		$profile_id                         = empty( $_POST['profile'] ) ? uniqid( rand() ) : sanitize_text_field( $_POST['profile'] );
		$profiles[ $profile_id ]['profile'] = $profile_id;
		if ( ! empty( $_POST['name'] ) ) {
			$profiles[ $profile_id ]['name'] = sanitize_text_field( strip_tags( $_POST['name'] ) );
		}

		foreach ( array( 'upload', 'download', 'project_id', 'workflow_id', 'primary_filter_id', 'secondary_filter_id', 'author_email', 'author_name', 'division', 'unit', 'campaign_id', 'channel', 'contact_email', 'contact_name', 'description', 'domain', 'style_id', 'purchase_order', 'reference_url', 'region', 'require_review' ) as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				$profiles[ $profile_id ][ $key ] = sanitize_text_field( $_POST[ $key ] );
			}

			if ( empty( $_POST[ $key ] ) || 'default' == sanitize_text_field( $_POST[ $key ] ) ) {
				unset( $profiles[ $profile_id ][ $key ] );
			}
		}

		$custom_profile_keys = array( 'download', 'project_id', 'workflow_id' );

		foreach ( $this->pllm->get_languages_list() as $language ) {
			$sanitized_language_slug = sanitize_text_field( $_POST['targets'][ $language->slug ] );
			switch ( $sanitized_language_slug ) {
				case 'custom':
					foreach ( $custom_profile_keys as $key ) {
						$sanitized_custom_lang_slug = sanitize_text_field( $_POST['custom'][ $key ][ $language->slug ] );
						if ( isset( $_POST['custom'][ $key ][ $language->slug ] ) && in_array( $sanitized_custom_lang_slug, array_keys( $settings[ $key ]['options'] ) ) ) {
							$profiles[ $profile_id ]['custom'][ $key ][ $language->slug ] = $sanitized_custom_lang_slug;
						}

						if ( $key != 'workflow_id' && ( empty( $_POST['custom'][ $key ][ $language->slug ] ) || 'default' == $sanitized_custom_lang_slug ) ) {
							unset( $profiles[ $profile_id ]['custom'][ $key ][ $language->slug ] );
						}
					}
					$profiles[ $profile_id ]['targets'][ $language->slug ] = sanitize_text_field( $_POST['targets'][ $language->slug ] );
					break;

				case 'disabled':
				case 'copy':
					$profiles[ $profile_id ]['targets'][ $language->slug ] = sanitize_text_field( $_POST['targets'][ $language->slug ] );
					foreach ( $custom_profile_keys as $key ) {
						unset( $profiles[ $profile_id ]['custom'][ $key ][ $language->slug ] );
					}
					break;

				case 'default':
					unset( $profiles[ $profile_id ]['targets'][ $language->slug ] );
					foreach ( $custom_profile_keys as $key ) {
						if ( $key !== 'workflow_id' ) {
							unset( $profiles[ $profile_id ]['custom'][ $key ][ $language->slug ] );
						}
					}
			}//end switch
			if ( $sanitized_language_slug != 'disabled' && isset( $_POST['custom']['workflow_id'][ $language->slug ] ) ) {
				$profiles[ $profile_id ]['custom']['workflow_id'][ $language->slug ] = sanitize_text_field( $_POST['custom']['workflow_id'][ $language->slug ] );
			}
			// If target workflow is set to default, and there is another target with a custom workflow, set default workflow id
			if ( $sanitized_language_slug === 'default' && in_array( 'custom', array_map( 'sanitize_text_field', $_POST['targets'] ) ) && isset( $_POST['custom']['workflow_id'][ $language->slug ] ) ) {
				$profiles[ $profile_id ]['custom']['workflow_id'][ $language->slug ] = $_POST['workflow_id'];
			} elseif ( $sanitized_language_slug != 'disabled' && isset( $_POST['custom']['workflow_id'][ $language->slug ] ) ) {
				$profiles[ $profile_id ]['custom']['workflow_id'][ $language->slug ] = sanitize_text_field( $_POST['custom']['workflow_id'][ $language->slug ] );
			}
		}//end foreach
		if ( ! isset( $_POST['custom']['workflow_id'] ) ) {
			unset( $profiles[ $profile_id ]['custom']['workflow_id'] );
		}

		// Add target locales to request
		$profiles[ $profile_id ]['target_locales'] = empty( $_POST['target_locales'] ) ? array() : array_map( 'sanitize_lingotek_locale', $_POST['target_locales'] );

		// Hardcode default values for automatic and manual profiles as the process above emptied them.
		$profiles['automatic']['upload'] = $profiles['automatic']['download'] = 'automatic';
		$profiles['manual']['upload']    = $profiles['manual']['download'] = 'manual';

		// Do not localize names here.
		$profiles['automatic']['name'] = 'Automatic';
		$profiles['manual']['name']    = 'Manual';
		$profiles['disabled']['name']  = 'Disabled';

		update_option( 'lingotek_profiles', $profiles, false );
		add_settings_error( 'lingotek_profile', 'default', __( 'Your translation profile was sucessfully saved.', 'lingotek-translation' ), 'updated' );

		if ( isset( $_POST['update_callback'] ) ) {
			$project_id = isset( $profiles[ $profile_id ]['project_id'] ) ? $profiles[ $profile_id ]['project_id'] : $defaults['project_id'];
			$client     = new Lingotek_API();
			if ( $client->update_callback_url( $project_id ) ) {
				add_settings_error( 'lingotek_profile', 'default', __( 'Your callback url was successfully updated.', 'lingotek-translation' ), 'updated' );
			}
		}
	}//end if
	settings_errors();
}//end if

?>
<h3><?php esc_html_e( 'Translation Profiles', 'lingotek-translation' ); ?></h3>
<p class="description">
	<?php esc_html_e( 'Translation profiles allow you to quickly configure and re-use translation settings.', 'lingotek-translation' ); ?>
</p>
<?php

$table = new Lingotek_Profiles_Table();
$table->prepare_items( $profiles );
?>
<style>
.tablenav {
	clear: none !important;
}
</style>
<?php
$table->display();
printf(
	'<a href="%s" class="button button-primary">%s</a>',
	esc_url(  admin_url( 'admin.php?page=lingotek-translation_manage&sm=edit-profile' ) ),
	esc_html( __( 'Add New Profile', 'lingotek-translation' ) )
);
