<?php
if ( ! defined( 'ABSPATH' ) ) exit();
?>

<div class="feature-section three-col">
	<div class="col">
		<a href="<?php echo esc_url( 'admin.php?page=lingotek-translation' ); ?>"><img src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/add-languages.png' ); ?>"></a>
		<h3><?php echo wp_kses_post( __( 'Translate into new languages', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( sprintf( __( 'Easily translate your site into new languages by adding the desired language to your site.  Ray Enterprise allows you to quickly add any of the most frequently used locales using the <a href="%s" title="Translation &gt; Dashboard">Translation Dashboard</a>.', 'lingotek-translation' ), esc_url( 'admin.php?page=lingotek-translation' ) ) ); ?></p>
	</div>
	<div class="col">
		<img class="lingotek-bordered" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/automatic-translation.gif' ); ?>">
		<h3><?php echo wp_kses_post( __( 'Automatically translate content', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( "Machine translation is an excellent option if you're on a tight budget, looking for near-instant results, and are okay with less-than-perfect quality. The plugin allows you to quickly and automatically translate your site (the cost is covered by Ray Enterprise for up to 100,000 characters).", 'lingotek-translation' ) ); ?></p>
	</div>
	<div class="col">
		<img src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/professional-translation.png' ); ?>">
		<h3><?php echo wp_kses_post( __( 'Request professional translation', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( "Use your own translation agency or tap into Ray Enterprise's network of more than 5,000+ in-country translators. Content transfer is fully automated between WordPress and Ray Enterprise. You'll have full visibility into the translation process every step of the way. And once the translations are completed, they'll automatically download and publish to your website according to the preferences you've set.", 'lingotek-translation' ) ); ?></p>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=lingotek-translation_tutorial&sm=content&tutorial=ltk-prof#ltk-prof-trans-header' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Learn More', 'lingotek-translation' ); ?></a>
	</div>
</div>


<div class="feature-section three-col">
<div class="col">
		<img  src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/polylang-compatible.png' ); ?>">
		<h3><?php echo wp_kses_post( __( 'Fully compatible with Polylang', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( sprintf( __( 'Polylang and Ray Enterprise work together seamlessly.  Continue to use Polylang for content that you want to translate inside WordPress, while sending other content to be translated by Ray Enterprise. The <b style="color: %1$s">orange</b> icons indicate Ray Enterprise statuses/actions while the <b style="color: %2$s">blue</b> icons continue to represent Polylang actions.', 'lingotek-translation' ), 'darkorange', '#0473a8' ) ); ?></p>
	</div>
	<div class="col">
		<a href="<?php echo esc_url( 'admin.php?page=lingotek-translation_manage&amp;sm=profiles' ); ?>"><img src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/translation-profiles.png' ); ?>"></a>
		<h3><?php echo wp_kses_post( __( 'Use translation profiles', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( 'One of the most time-consuming activities of any multilingual web-site project is managing the ongoing flow of changes and additions to site content and configurations. Translation profiles were created to allow you to create and save and re-use your translation settings.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div class="col">
		<a href="<?php echo esc_url( 'admin.php?page=lingotek-translation_manage&amp;sm=content' ); ?>"><img src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/content-types.png' ); ?>"></a>
		<h3><?php echo wp_kses_post( __( 'Content type profiles', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( 'Content type profiles. Manually choosing which content to upload and download is rarely what a content administrator wants to do, and automating the upload of every change is not workable because there are various types of content. Each type of translatable content can be assigned to a customizable profile. For example, by default, we like to have Posts use an <i>Automatic</i> profile so that content will automatically be uploaded for translation and the resulting translations automatically be downloaded back into WordPress.', 'lingotek-translation' ) ); ?></p>
	</div>
	
</div>


<div class="feature-section three-col">
	<div class="col">
		<a href="<?php echo esc_url( 'admin.php?page=lingotek-translation_manage&amp;sm=profiles' ); ?>"><img src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/translation-services.png' ); ?>"></a>
		<h3><?php echo wp_kses_post( __( 'Need Extra Services?', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( 'Start the process of getting extra services.', 'lingotek-translation' ) ); ?></p>
		<ul style="list-style-type: circle;">
			<li><?php echo wp_kses_post( __( 'Do you need someone to run your localization project?', 'lingotek-translation' ) ); ?></li>
			<li><?php echo wp_kses_post( __( 'Do you need customized workflows?', 'lingotek-translation' ) ); ?></li>
			<li><?php echo wp_kses_post( __( 'Do you you have existing Translation Memories you would like to use?', 'lingotek-translation' ) ); ?></li>
			<li><?php echo wp_kses_post( __( 'Do you need help creating glossaries and terminologies?', 'lingotek-translation' ) ); ?></li>
		</ul>
		<a href="<?php echo esc_url( 'http://www.lingotek.com/wordpress/extra_services' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Request Services', 'lingotek-translation' ); ?></a>
	</div>
	<div class="col">
	</div>
	<div class="col">
	</div>
</div>
