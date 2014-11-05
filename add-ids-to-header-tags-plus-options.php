<?php

/**
 * Plugin options fields
 */

function addIDs_settings_field_link_text() {
    $options = addIDs_get_plugin_settings();
    ?>
    <input type="text" name="addIDs_plugin_settings[link_text]" id="link-text" value="<?php echo esc_attr( $options['link_text'] ); ?>" /><br />
    <label class="description" for="link-text"><?php _e( 'Default: <code>none</code>. Can include markup.', 'addIDs' ); ?></label>
    <?php
}





/**
 * Theme options menu
 */

// Register the theme options page and its fields
function addIDs_plugin_settings_init() {
    register_setting(
        'addIDs_options', // Options group, see settings_fields() call in addIDs_plugin_settings_render_page()
        'addIDs_plugin_settings', // Database option, see addIDs_get_plugin_settings()
        'addIDs_plugin_settings_validate' // The sanitization callback, see addIDs_plugin_settings_validate()
    );

    // Register our settings field group
    add_settings_section(
        'general', // Unique identifier for the settings section
        '', // Section title (we don't want one)
        '__return_false', // Section callback (we don't want anything)
        'addIDs_plugin_settings' // Menu slug, used to uniquely identify the page; see addIDs_plugin_settings_add_page()
    );

    add_settings_field( 'link_text', 'Link Test', 'addIDs_settings_field_link_text', 'addIDs_plugin_settings', 'general' );
}
add_action( 'admin_init', 'addIDs_plugin_settings_init' );



// Create theme options menu
// The content that's rendered on the menu page.
function addIDs_plugin_settings_render_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php _e( 'Add IDs to Header Tags Settings', 'addIDs' ); ?></h2>

        <form method="post" action="options.php">
            <?php
                settings_fields( 'addIDs_options' );
                do_settings_sections( 'addIDs_plugin_settings' );
                submit_button();
            ?>
        </form>
    </div>
    <?php
}



// Add the theme options page to the admin menu
function addIDs_plugin_settings_add_page() {
    $theme_page = add_submenu_page(
        'options-general.php', // parent slug
        'Add IDs to Header Tags', // Label in menu
        'Add IDs to Header Tags', // Label in menu
        'edit_theme_options', // Capability required
        'addIDs_plugin_settings', // Menu slug, used to uniquely identify the page
        'addIDs_plugin_settings_render_page' // Function that renders the options page
    );
}
add_action( 'admin_menu', 'addIDs_plugin_settings_add_page' );



// Restrict access to the theme options page to admins
function addIDs_option_page_capability( $capability ) {
    return 'edit_theme_options';
}
add_filter( 'option_page_capability_addIDs_options', 'addIDs_option_page_capability' );





/**
 * Process theme options
 */

// Get the current options from the database.
// If none are specified, use these defaults.
function addIDs_get_plugin_settings() {
    $saved = (array) get_option( 'addIDs_plugin_settings' );
    $defaults = array(
        'link_text' => '',
    );

    $defaults = apply_filters( 'addIDs_default_plugin_settings', $defaults );

    $options = wp_parse_args( $saved, $defaults );
    $options = array_intersect_key( $options, $defaults );

    return $options;
}



// Sanitize and validate updated theme options
function addIDs_plugin_settings_validate( $input ) {
    $output = array();

    if ( isset( $input['link_text'] ) && ! empty( $input['link_text'] ) )
        $output['link_text'] = wp_filter_post_kses( $input['link_text'] );

    return apply_filters( 'addIDs_plugin_settings_validate', $output, $input );
}





/**
 * Get theme options
 */

function addIDs_get_link_text() {
    $options = addIDs_get_plugin_settings();
    return $options['link_text'];
}
