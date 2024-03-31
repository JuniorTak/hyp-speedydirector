<?php 
/* Create custom settings menu */
add_action('admin_menu', 'director_create_menu');
function director_create_menu() {
    // Create new submenu
    add_submenu_page( 'themes.php', 'Theme Options', 'Speedy Director', 'administrator', 'theme-options', 'director_settings_page');
    // Call register settings function
    add_action( 'admin_init', 'director_register_settings' );
}

function director_register_settings() {
    // Register our settings
    register_setting( 'director-settings-group', 'director_logo', 'handle_logo_upload');
    register_setting( 'director-settings-group', 'director_facebook' );
    register_setting( 'director-settings-group', 'director_twitter' );
    register_setting( 'director-settings-group', 'director_rss' );
    register_setting( 'director-settings-group', 'director_analytics' );
}

/* Build our theme settings page */
function director_settings_page() {
    ?>
    <style type="text/css">
        <?php include('theme-options.css'); ?>
    </style>
    <div class="wrap">
    <h2>Speedy Director Theme Settings</h2>
    <?php settings_errors(); ?>
    <form id="landingOptions" method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('director-settings-group'); ?>
        <table class="form-table">
            <tr valign="top">
                <?php $logo = get_option('director_logo'); ?>
                <th scope="row">Logo:</th>
                <td>
                    <?php if($logo) : ?>
                        <br/><img src="<?php print $logo; ?>" alt="<?php bloginfo('name'); ?>" /><br/>
                    <?php endif; ?>
                    <input type="hidden" name="logourl" value="<?php print $logo; ?>" readonly />
                    <input type="file" name="director_logo" id="director_logo"/><br/>
                    <?php if($logo) : ?>
                        <label for="director_logo">*Click to replace</label>
                    <?php else : ?>
                        <label for="director_logo">*Click to upload</label>
                    <?php endif; ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Facebook Link:</th>
                <td>
                    <input type="text" name="director_facebook" value="<?php print get_option('director_facebook'); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Twitter Link:</th>
                <td>
                    <input type="text" name="director_twitter" value="<?php print get_option('director_twitter'); ?>" />
                </td>
            </tr>
            <tr>
                <th scope="row">Display RSS Icon:</th>
                <td>
                    <input type="checkbox" name="director_rss" <?php if(get_option('director_rss') == true) print "checked"; ?> />
                </td>
            </tr>
            <tr>
                <th scope="row">Google Analytics Code:</th>
                <td>
                    <textarea name="director_analytics"><?php print get_option('director_analytics'); ?></textarea>
                </td>
            </tr> 
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>
<?php } 

/* Handle the logo upload */
function handle_logo_upload()
{
    if(isset($_FILES['director_logo']) && !empty($_FILES['director_logo']['name']))
    {
        $upload = wp_handle_upload($_FILES['director_logo'], array('test_form' => FALSE));

        if(!empty($upload['error'])) {
        	wp_die($upload['error']);
        }

        // Add our uploaded logo into WordPress media library
		$attachment_id = wp_insert_attachment(
			array(
				'guid'           => $upload['url'],
				'post_mime_type' => $upload['type'],
				'post_title'     => basename($upload['file']),
				'post_content'   => '',
				'post_status'    => 'inherit',
			),
			$upload['file']
		);

		if(is_wp_error($attachment_id) || !$attachment_id) {
			wp_die('Upload error.');
		}

		// Update medatata, regenerate image sizes
		wp_update_attachment_metadata(
			$attachment_id,
			wp_generate_attachment_metadata($attachment_id, $upload['file'])
		);

        $url = $upload['url'];
        return $url;
    }
 	elseif(isset($_FILES['director_logo']) && empty($_FILES['director_logo']['name'])){
 		$url = $_POST['logourl'];
 		return $url;
 	}
 	return $option;
}

?>