<?php
if ( ! defined( 'ABSPATH' ) ) exit();
?>
<!-- Redirect Access Token -->
<script>
jQuery(document).ready(function ($) {
    $('form').on('submit', function (event) {
        event.preventDefault();
        
        // Get the access token from the input field
        var access_token = $('#access_token').val();
		var redirect_url = window.location.origin + window.location.pathname + window.location.search;
		//Validate the token
		var api_url = 'https://myaccount.lingotek.com/api/community';
		$.ajax({
            type: 'GET',
            url: api_url,
            headers: {
                'Authorization': 'Bearer'+ access_token,
            },
            success: function (response) {
                console.log('success');
				console.log(redirect_url);
				var request_data = {
            		'action': 'lingotek_authorization_action',
        		}
				$.ajax({
            	type: 'POST',
            	url: ajaxurl,
            	data: request_data,
            	headers: {
                	'Token': access_token,
            	},
            	success: function (response) {
                	console.log('success');
            	},
            	error: function (xhr, status, error) {
                console.log('failed', status, error);
           	 	}
        		}).then(function (data) {
					if ( redirect_url.includes('delete_access_token') ) {
						redirect_url = redirect_url.replace('&delete_access_token=true', '');
					} else if ( redirect_url.includes('update_access_token') ) {
						redirect_url = redirect_url.replace('&update_access_token=true', '');
					}
					window.location.href = redirect_url;
				});	
            },
            error: function (xhr, status, error) {
                console.log('failed', status, error);
				jQuery('#wpbody-content').prepend('<div class="error"><p>'+'Invalid Token. Please check your token and try again.'+'</p></div>');
            }
        });		
    });
});
</script>

<!-- Connect Your Account Button -->
<div class="loader content" hidden></div>
<div class="wrap content">
	<?php if ( !$update_access_token ) : ?>
		<h2><?php esc_html_e( 'Connect Your Account', 'lingotek-translation' ); ?></h2>
		
		<p class="description">
			<?php esc_html_e( 'If you dont have a Ray Enterprise account, click the link below for inquiry.', 'lingotek-translation' ); ?>
		</p>
		<hr/>
		<p>
			<a class="button button-large button-hero" href="<?php echo esc_url( $connect_account_cloak_url_new ); ?>">
				<img src="<?php echo esc_url( LINGOTEK_URL ); ?>/img/rayEnterpriseIcon.svg" style="padding: 0 4px 2px 0; width: 25px" align="absmiddle"/> <?php esc_html_e( 'Connect New Account', 'lingotek-translation' ); ?>
			</a>
		</p>
		<hr/>
		<p class="description">
			<?php esc_html_e( 'To begin the setup of this Ray Enterprise configuration, you need to set up your token and connect your Ray Enterprise account.', 'lingotek-translation' ); ?>
		</p>
	<?php endif; ?>
	<div>
		<form method="post">
			</br>
			<div class="form-group">
				<label for="access_token"><strong> Access Token </strong> <em>(Token currently used when communicating with Ray Enterprise service)</em>:</label>
				<br>
				<div style="margin:15px 15px 15px 0px">
					<input type="text" id="access_token" name="access_token" class="form-control my-custom-class" style="width: 300px; height: 45px;" placeholder="Enter access token" required>
					<button class="button button-large button-hero" type="submit" style="margin-left: 2px;"> <?php if ( $update_access_token ) : ?> Update Token <?php else : ?> Connect <?php endif; ?>			</button>
				</div>
			</div>
		</form>
		<a href="https://myaccount.lingotek.com/connect/setup/780966c9-f9c8-4691-96e2-c0aaf47f62ff" target="_blank">Generate a new token</a>
		<br>
		<hr/>
	</div>
</div>
<style>
.loader {
	border: 16px solid #dedede;
	border-top: 16px solid #3498db;
	border-radius: 50%;
	width: 100px;
	height: 100px;
	animation: spin 1.5s linear infinite;
	animation-direction: reverse;
	margin: 7em;
}

@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}
</style>
