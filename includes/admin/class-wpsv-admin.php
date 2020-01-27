<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class WPSV_admin {
    public function __construct() {
    	// Hook into the admin menu
    	add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );

    	// Add Settings and Fields
    	add_action( 'admin_init', array( $this, 'setup_sections' ) );
    	add_action( 'admin_init', array( $this, 'setup_fields' ) );
	}

    public function wpsv_add_required_scripts() {
        if( is_admin()) {
            // Adds the color picker CSS File
            wp_enqueue_style( 'wp-color-picker' ); 

            // Includes jQuery file with WordPress Color Picker dependency
            wp_enqueue_script( 'wpsv-script-handle', WPSV_INC_URL.'/wpsv-script.js', array( 'wp-color-picker' ), false, true );
        }
    }

	public function create_plugin_settings_page() {
    	// Add the menu item and page
    	$page_title = 'WP Site Version Settings';
    	$menu_title = 'WP Site Version';
    	$capability = 'manage_options';
    	$slug = 'wpsv_fields';
    	$callback = array( $this, 'plugin_settings_page_content' );
    	add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback );
    }

    public function plugin_settings_page_content() {?>
    	<div class="wrap">
    		<h2>WP Site Version Settings</h2>
    		<p>Lorem Ipsum, for the moment.</p>
    		<form method="post" action="options.php">
    			<?php 
    				settings_fields ( 'wpsv_fields' );
    				do_settings_sections( 'wpsv_fields' );
    				submit_button();
    			?>
    		</form>
    	</div>
    <?php}

	public function admin_notice() { ?>
        <div class="notice notice-success is-dismissible">
            <p>Your settings have been updated!</p>
        </div><?php
    }

    public function setup_sections() {
    	add_settings_section( 'wpsv_first_section', 'Text to Appear in Admin Bar', array( $this, 'section_callback' ), 'wpsv_fields' );
    	add_settings_section( 'wpsv_second_section', 'Color for Admin Bar', array( $this, 'section_callback' ), 'wpsv_fields' );
	}

	public function section_callback( $arguments ) {
    	switch( $arguments['id'] ){
    		case 'wpsv_first_section':
    			echo 'Enter the text that you would like to appear in the Admin bar.';
    			break;
    		case 'wpsv_second_section':
    			echo 'Select the color you would like the admin bar to be.';
    			break;
    	}
    }

    public function setup_fields() {
    	$fields = array(
	        array(
	            'uid' => 'wpsv_first_field',
	            'label' => 'Display Text',
	            'section' => 'wpsv_first_section',
	            'type' => 'text',
	            'placeholder' => 'Live',
	            'default' => 'Live'
	        ),
            array(
                'uid' => 'wpsv_second_field',
                'label' => 'Color',
                'section' => 'wpsv_second_section',
                'class' => 'color-field',
                'type' => 'text',
                'placeholder' => '',
                'default' => '#23282D'
            )
    	);
    	foreach( $fields as $field ){
        	add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'wpsv_fields', $field['section'], $field );
       		register_setting( 'wpsv_fields', $field['uid'] );
   	 	}
}

	public function field_callback( $arguments ) {
            $value = get_option( $arguments['uid'] );
            if( ! $value ) {
                $value = $arguments['default'];
            }
            switch( $arguments['type'] ){
                case 'text':
                case 'password':
                case 'number':
                    printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
                    break;
            }
        }
    function add_hooks(){
        add_action( 'admin_enqueue_scripts', array( $this, 'wpsv_add_required_scripts' ) );
    }
}