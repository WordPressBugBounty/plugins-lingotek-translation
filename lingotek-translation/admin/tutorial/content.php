<?php
if ( ! defined( 'ABSPATH' ) ) exit();
?>
<style>
	.tutorial-photo-right {
		width: 50%;
		height: auto;
		float: right;
		padding-left: 3px;
	}

	.img-caption {
		font-size:  8px;
		color: #999;
		font-style: italic;
		padding-left: 20px;
	}

	th {
		text-align: left;
		padding-left: 10px;
	}
</style>
<h4>
	<?php echo wp_kses_post( __( 'What Does The Ray EnterpriseTranslation Plugin Do?', 'lingotek-translation' ) ); ?>
	<a id="cd-show-link-summary" class="dashicons dashicons-arrow-right" onclick="document.getElementById('ltk-summary').style.display = ''; document.getElementById('cd-hide-link-summary').style.display = ''; this.style.display = 'none'; return false;"></a>
	<a id="cd-hide-link-summary" class="dashicons dashicons-arrow-down" onclick="document.getElementById('ltk-summary').style.display = 'none'; document.getElementById('cd-show-link-summary').style.display = ''; this.style.display = 'none'; return false;" style="display: none;"></a>
</h4>
<p id="ltk-summary" style="display:none; margin-left: 25px;"><?php echo wp_kses_post( __( 'Ray Enterprise works in conjunction with the Polylang plugin (the plumbing to make WordPress multilingual ready) simplifying the process of creating and maintaining your multilingual website. You write posts, pages, and create categories and post tags as usual, and then define the language for each of them.', 'lingotek-translation' ) ); ?></p>

<h4>
	<?php echo wp_kses_post( __( 'Ray Enterprise Translation General Overview', 'lingotek-translation' ) ); ?>
	<a id="cd-show-link-gen" class="dashicons dashicons-arrow-right" onclick="document.getElementById('gen-overview-tut').style.display = ''; document.getElementById('cd-hide-link-gen').style.display = ''; this.style.display = 'none'; return false;"></a>
	<a id="cd-hide-link-gen" class="dashicons dashicons-arrow-down" onclick="document.getElementById('gen-overview-tut').style.display = 'none'; document.getElementById('cd-show-link-gen').style.display = ''; this.style.display = 'none'; return false;" style="display: none;"></a>
</h4>
<div id="gen-overview-tut" style="display:none;margin-left: 25px;">
	<div>
		<h4><?php echo wp_kses_post( __( '1. Create content', 'lingotek-translation' ) ); ?></h4>
		<p><?php echo wp_kses_post( __( 'Whether you write a blog post, create a page for your site, or have existing posts and pages, any of your WordPress content can be uploaded to <i>Ray Enterprise</i>.', 'lingotek-translation' ) ); ?>
		<?php echo wp_kses_post( __( 'The examples shown below are for Pages but translation for other content types works the same way!', 'lingotek-translation' ) ); ?></p>
		<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/add-page.png' ); ?>">
		<p class="img-caption"><?php echo wp_kses_post( __( 'Create a new page for translation.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div>
		<h4><?php echo wp_kses_post( __( '2. Upload content to Ray Enterprise', 'lingotek-translation' ) ); ?></h4>
		<p><?php echo wp_kses_post( __( 'Your WordPress content can be uploaded to <i>Ray Enterprise</i> with the simple push of a button.', 'lingotek-translation' ) ); ?></p>
		<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/ready-to-upload.png' ); ?>">
		<p class="img-caption"><?php echo wp_kses_post( __( 'Content has been created and is ready for upload to Ray Enterprise.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div>
		<h4><?php echo wp_kses_post( __( '3. Request translations for target languages', 'lingotek-translation' ) ); ?></h4>
		<p><?php echo wp_kses_post( __( 'Request translation for a specific language by clicking on the orange plus icon, for all languages at once, or in bulk by using the <i>Bulk Actions</i> dropdown.', 'lingotek-translation' ) ); ?></p>
			<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/request-translations.png' ); ?>">
		<p class="img-caption"><?php echo wp_kses_post( __( 'The source content is uploaded and ready for target languages.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div>
		<h4><?php echo wp_kses_post( __( '4. Translate your content', 'lingotek-translation' ) ); ?></h4>
		<p><?php echo wp_kses_post( __( 'Your content will now be translated into your selected target languages by free machine translation or, if you contract with <i>Ray Enterprise</i>, professional translation services.', 'lingotek-translation' ) ); ?></p>
		<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/translations-underway.png' ); ?>">
		<p class="img-caption"><?php echo wp_kses_post( __( 'Your translations are underway.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div>
		<h4><?php echo wp_kses_post( __( '5. Download translations', 'lingotek-translation' ) ); ?></h4>
		<p><?php echo wp_kses_post( __( 'Once your translations are complete they will be marked ready for download. You can download translations for all languages, each language individually, or in bulk (using the <i>Bulk Actions</i> dropdown).', 'lingotek-translation' ) ); ?></p>
		<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/translations-ready-for-download.png' ); ?>">
		<p class="img-caption"><?php echo wp_kses_post( __( 'Your translations are ready for download.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div>
	<h4><?php echo wp_kses_post( __( '6. Your content is translated!', 'lingotek-translation' ) ); ?></h4>
	<p><?php echo wp_kses_post( __( 'The orange pencil icons indicate that your translations are finished, downloaded, and current within your WordPress site. Clicking on any one of the pencils will direct you to the Ray Enterprise Workbench for that specific language. Here you can make updates and changes to your translations if necessary.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/translations-downloaded.png' ); ?>">
	<p class="img-caption"><?php echo wp_kses_post( __( 'Your content has been translated.', 'lingotek-translation' ) ); ?></p>
</div>

<h2><?php echo wp_kses_post( __( 'What do all the icons mean?', 'lingotek-translation' ) ); ?></h2>

<table>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-upload"></span></td>
		<th><?php echo wp_kses_post( __( 'Upload Source', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'There is content ready to be uploaded to Lingotek.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-clock"></span></td>
		<th><?php echo wp_kses_post( __( 'In Progress', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'Content is importing to Ray Enterprise or a target language is being added to source content.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-yes"></span></td>
		<th><?php echo wp_kses_post( __( 'Source Uploaded', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'The source content has been uploaded to Ray Enterprise.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-plus"></span></td>
		<th><?php echo wp_kses_post( __( 'Request Translation', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'Request a translation of the source content. (Add a target language)', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-download"></span></td>
		<th><?php echo wp_kses_post( __( 'Download Translation', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'Download the translated content to WordPress.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-edit"></span></td>
		<th><?php echo wp_kses_post( __( 'Translation Current', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'The translation is complete. (Clicking on this icon will allow you to edit translations in the Ray Enterprise Workbench)', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-warning"></span></td>
		<th><?php echo wp_kses_post( __( 'Translation Cancelled', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'The translation is cancelled. The source cannot be translated into this language again.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-remove"></span></td>
		<th><?php echo wp_kses_post( __( 'Document Archived', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'The document is archived. The document can be translated again.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-remove"></span></td>
		<th><?php echo wp_kses_post( __( 'Translation Deleted', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'The translation is deleted. The source can be translated into this language again.', 'lingotek-translation' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="lingotek-color dashicons dashicons-no"></span></td>
		<th><?php echo wp_kses_post( __( 'Out of Sync', 'lingotek-translation' ) ); ?></th>
		<td><?php echo wp_kses_post( __( 'You have made changes to source content. The source must be sent to Ray Enterprise again for additional translation.', 'lingotek-translation' ) ); ?></td>
	</tr>
</table>
</div>
<h4 id="ltk-prof-trans-header">
	<?php echo wp_kses_post( __( 'Ray Enterprise Professional Translation Overview', 'lingotek-translation' ) ); ?>
	<a id="cd-show-link" class="dashicons dashicons-arrow-right" onclick="document.getElementById('pro-translation-tut').style.display = ''; document.getElementById('cd-hide-link').style.display = ''; this.style.display = 'none'; return false;" style="
	<?php
	if ( 'ltk-prof' === sanitize_text_field( filter_input( INPUT_GET, 'tutorial' ) ) ) {
		echo 'display: none;'; }
	?>
	"></a>
	<a id="cd-hide-link" class="dashicons dashicons-arrow-down" onclick="document.getElementById('pro-translation-tut').style.display = 'none'; document.getElementById('cd-show-link').style.display = ''; this.style.display = 'none'; return false;" style="
	<?php
	if ( 'ltk-prof' !== sanitize_text_field( filter_input( INPUT_GET, 'tutorial' ) ) ) {
		echo 'display: none;'; }
	?>
	"></a>
</h4>
<div id="pro-translation-tut" style="
<?php
if ( 'ltk-prof' != sanitize_text_field( filter_input( INPUT_GET, 'tutorial' ) ) ) {
	echo 'display: none;'; }
?>
 margin-left: 25px;">
	<h4><?php echo wp_kses_post( __( 'What Is Ray Enterprise Professional Translation?', 'lingotek-translation' ) ); ?></h4>
	<p><?php echo wp_kses_post( __( 'Ray Enterprise Professional Translation is a workflow that allows you to connect with audiences around the globe using Ray Enterprise\'s network of 5000+ professional, in-country, translators. Professional Translation ensures that your audiences will feel the sentiment of your content.', 'lingotek-translation' ) ); ?></p>
	<h4><?php echo wp_kses_post( __( 'How To Use', 'lingotek-translation' ) ); ?></h4>
	<p><?php echo wp_kses_post( __( 'Use the "Ray Enterprise Professional Translation" workflow to enable this feature.  This can be done from any of the following area in the Ray Enterprise plugin settings:', 'lingotek-translation' ) ); ?></p>
	<ul>
		<li><strong><?php echo wp_kses_post( __( 'Translation > Manage > Translation Profiles', 'lingotek-translation' ) ); ?></strong></li>
		<li><strong><?php echo wp_kses_post( __( 'Translation > Settings > Defaults', 'lingotek-translation' ) ); ?></strong></li>
	</ul>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/combined-selection.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'After selecting this workflow a dialog box will pop up prompting you to enter a payment method. Clicking LATER will close the dialog box and allow you to come back later to add a payment method.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/selection-workflow-from-list.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'Clicking the ADD PAYMENT METHOD button will redirect you to the Ray Enterprise Secure Payment Portal.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/redirected-to-payment-portal-screen.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'From the Payment Portal you will enter your payment information. Then you will be redirected back to your WordPress site.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/redirected-to-payment-portal.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'After the workflow has been set you can access the professional translation request menu by clicking on the orange plus icon located on any page that contains your posts.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/request-translations.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'When requesting a document for translation with the Ray Enterprise Professional Translation workflow enabled you will see one of two dialog boxes. If you don\'t have a payment method set up you will see the following dialog box allowing you to view translation quotes on your selected documents.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/quote-calculator.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'If you do have a payment method enabled you will see the following dialog box that will allow you to purchase your professional translations.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/higher-res-buy-now.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'After purchasing one or more professional translations you will see a success message and will receive a payment confirmation email.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/purchased.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'The status of your translation will change to the Translator icon while your document is being processed and translated.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/professional-translation-icon.png' ); ?>">
	<p><?php echo wp_kses_post( __( 'You can set up or edit your payment method from the Translation > Settings > Account page.', 'lingotek-translation' ) ); ?></p>
	<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/change-account-settings.png' ); ?>">
</div>
