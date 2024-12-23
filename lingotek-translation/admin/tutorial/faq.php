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
</style>

<p class="about-description"><?php esc_html_e( 'Questions and answers...', 'lingotek-translation' ); ?></p>

<b><?php echo wp_kses_post( __( 'How does this really work?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( __( '<i>Polylang</i> puts in the framework to make WordPress multilingual and <i>Ray Enterprise</i> leverages that framework to provide localization through machine translation and professional translation services.', 'lingotek-translation' ) ); ?></p>

<b><?php echo wp_kses_post( __( 'What does the Ray Enterprise plugin do?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( __( '<i>Ray Enterprise</i> has teamed up with <i>Polylang</i> to offer a simple way to make your WordPress site truly multilingual. Manage all your multilingual content in the same site. No need to have a different site for each language!', 'lingotek-translation' ) ); ?></p>

<b><?php echo wp_kses_post( __( 'How can I add a language?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( __( 'On the <i>translation dashboard</i>, click on the <i>Translate my site into...</i> textbox and choose from the list or start typing to quickly find a language.', 'lingotek-translation' ) ); ?></p>

<b><?php echo wp_kses_post( __( 'How can I remove a language?', 'lingotek-translation' ) ); ?></b>
<p>
	<?php echo wp_kses_post( __( 'On the <i>translation dashboard</i>, click on the blue check mark for the language you would like to remove.', 'lingotek-translation' ) ); ?>
	<i><?php echo wp_kses_post( __( 'Note: If you have translated content in a language you will not be able to remove that language until that content has been deleted.', 'lingotek-translation' ) ); ?></i>
</p>

<b><?php echo wp_kses_post( __( "Why can't I upload my existing content to Ray Enterprise?", 'lingotek-translation' ) ); ?></b>
<p><?php wp_kses_post( sprintf( __( "You must assign a language to content that existed before you installed the <i>Polylang</i> and <i>Ray Enterprise</i> plugins. You can do this manually or use the <a href='%s'><i>Ray Enterprise Language Utility</i></a> to set all content that doesn't have an assigned language to the default language. This will allow you to upload your existing content to Ray Enterprise.", 'lingotek-translation' ), esc_url( 'admin.php?page=lingotek-translation_settings&sm=utilities' ) ) ); ?></p>

<b><?php echo wp_kses_post( __( 'Can I use my own translation agency with Ray Enterprise?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( __( "Use your own translation agency or tap into Ray Enterprise's network of more than 5,000+ in-country translators. Content transfer is fully automated between WordPress and Ray Enterprise. You'll have full visibility into the translation process every step of the way. And once the translations are completed, they'll automatically download and publish to your website according to the preferences you've set.", 'lingotek-translation' ) ); ?></p>

<b><?php echo wp_kses_post( __( 'How can I check the overall translation progress of my site?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( __( 'On the <i>translation dashboard</i>, the bars under <i>Completed Percentage</i> show the translation progress of content for each language. You can filter by content type or show progress for all content.', 'lingotek-translation' ) ); ?></p>
<ul>
	<li>
		<b><?php echo wp_kses_post( __( 'Why are there two different shades of blue in the progress bar?', 'lingotek-translation' ) ); ?></b>
		<p><?php echo wp_kses_post( __( 'The <i>translation dashboard</i> not only shows how much of your content is translated, but also indicates the language that your source content was authored in.', 'lingotek-translation' ) ); ?></p>
	</li>
	<ul style="list-style-type:disc; padding-left:30px">
		<li><?php echo wp_kses_post( __( '<i>Dark Blue:</i> Indicates that this is a source language that the content was authored in.', 'lingotek-translation' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<i>Light Blue:</i> Indicates that this is a target language that the content was translated into.', 'lingotek-translation' ) ); ?></li>
	</ul>
</ul>

<b><?php echo wp_kses_post( __( 'What happens when I <i>Disassociate Translations</i>?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( __( 'When content is disassociated, the connection between WordPress and <i>Ray Enterprise</i> is safely removed so that translations can be solely managed inside of WordPress.', 'lingotek-translation' ) ); ?></p>

<b><?php echo wp_kses_post( __( 'How do I translate strings within widgets or general WordPress settings (e.g., Site Title, Tagline)?', 'lingotek-translation' ) ); ?></b>
<p><?php echo wp_kses_post( sprintf( __( "Groups of strings can be sent for translation and managed using the <a href='%1\$s'>String Groups</a> page. Individual strings may be viewed on the <a href='%2\$s'>Strings</a> page.", 'lingotek-translation' ), esc_url( 'admin.php?page=lingotek-translation_manage&sm=string-groups' ), esc_url( 'admin.php?page=lingotek-translation_manage&sm=strings' ) ) ); ?></p>


<div class="changelog feature-section two-col">
	<div>
		<img class="workbench-image" src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/workbench-full.png' ); ?>">
		<h3><?php echo wp_kses_post( __( 'Ray Enterprise Workbench', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( 'Ray Enterprise Translation is the only WordPress plugin to integrate a Translation Management System directly into WordPress, thus allowing the WordPress community to use professional-grade translation technologies (e.g. machine translation, translation memory, CAT tool) without ever having to leave the comfort of the WordPress environment.', 'lingotek-translation' ) ); ?></p>
	</div>
	<div class="last-feature">
		<a href="admin.php?page=lingotek-translation"><img src="<?php echo esc_url( LINGOTEK_URL . '/admin/tutorial/img/dashboard.png' ); ?>"></a>
		<h3><?php echo wp_kses_post( __( 'Translation Dashboard', 'lingotek-translation' ) ); ?></h3>
		<p><?php echo wp_kses_post( __( 'The <i>translation dashboard</i> allows you to view your site languages, add and remove new languages, check the overall translation progress of your site, see site analytics, and connect with Ray Enterprise support.', 'lingotek-translation' ) ); ?></p>
	</div>
</div>



