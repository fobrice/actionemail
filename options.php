<?php
class EmailActionSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Mail Action Admin',
            'Mail Action Admin',
            'manage_options',
            'action_email-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'action_email_name' );
        ?>
        <div class="wrap">
            <h1>Paramètres du plugin action email</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'action_email_group' );
                do_settings_sections( 'action_email-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'Email providers', // Option group
            'Email providers', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'action_email-admin' // Page
        );

        add_settings_field(
            'email_providers', // ID
            'Email providers', // Title
            array( $this, 'email_providers_callback' ), // Callback
            'action_email-admin', // Page
            'setting_section_id' // Section
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function email_providers_callback()
    {
        printf(
            '<textarea rows=50 id="email_providers" name="action_email_name[email_providers]"  >%s</textarea>',
            isset( $this->options['email_providers'] ) ? esc_attr( $this->options['email_providers']) : ''
        );
    }

}
