<?php
class WB_Priority_Port_Paye_Settings {

    /**
	 * Hooks & Filters
	 *
	 * @since 1.0
	 * @public
	 */
	public function __construct () {        
        add_action( 'admin_init', array( $this, 'port_paye_settings_init'), 10, 1);
        add_action( 'admin_menu', array( $this, 'port_paye_options_page'), 10, 1);
	}

    public function port_paye_settings_init() {
        register_setting( 'port_paye', 'port_paye_options', array( $this , 'sanitize') );
        
        add_settings_section(
            'port_paye_section_developers',
            '',
            array( $this, 'port_paye_section_developers'),
            'port_paye'
        );
        
        add_settings_field(
            'port_paye_field_tarra',
            __( 'Tarra', 'port_paye' ),
            array( $this, 'port_paye_field_tarra'),
            'port_paye',
            'port_paye_section_developers',
            [
                'label_for' => 'port_paye_field_tarra',
                'class' => 'port_paye_row',
                'port_paye_custom_data' => 'custom',
            ]
        );
        
        add_settings_field(
            'port_paye_field_tarra_input',
            __( 'Oma marginaali', 'port_paye' ),
            array( $this, 'port_paye_field_tarra_input'),
            'port_paye',
            'port_paye_section_developers',
            [
                'label_for' => 'port_paye_field_tarra_input',
                'class' => 'port_paye_row',
                'port_paye_custom_data' => 'custom',
            ]
        );
        
        add_settings_field(
            'port_paye_field_tarra_input2',
            __( 'Lähettäjän nimi', 'port_paye' ),
            array( $this, 'port_paye_field_tarra_input2'),
            'port_paye',
            'port_paye_section_developers',
            [
                'label_for' => 'port_paye_field_tarra_input2',
                'class' => 'port_paye_row',
                'port_paye_custom_data' => 'custom',
            ]
        );
        
        add_settings_field(
            'port_paye_field_tarra_input3',
            __( 'Ylämarginaali', 'port_paye' ),
            array( $this, 'port_paye_field_tarra_input3'),
            'port_paye',
            'port_paye_section_developers',
            [
                'label_for' => 'port_paye_field_tarra_input3',
                'class' => 'port_paye_row',
                'port_paye_custom_data' => 'custom',
            ]
        );
        
        add_settings_field(
            'port_paye_field_tarra_input4',
            __( 'Vasen marginaali', 'port_paye' ),
            array( $this, 'port_paye_field_tarra_input4'),
            'port_paye',
            'port_paye_section_developers',
            [
                'label_for' => 'port_paye_field_tarra_input4',
                'class' => 'port_paye_row',
                'port_paye_custom_data' => 'custom',
            ]
        );
    }

    public function port_paye_section_developers( $args ) {
        ?>
            <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Port Paye lisäosan asetukset', 'port_paye' ); ?></p>
        <?php
    }

    public function port_paye_field_tarra( $args ) {
        $options = get_option( 'port_paye_options' );
        ?>

        <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['port_paye_custom_data'] ); ?>"name="port_paye_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
            <option value="a4" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'a4', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'A4 tarra', 'port_paye' ); ?>
            </option>
        
            <option value="a5" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'a5', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'A5 tarra', 'port_paye' ); ?>
            </option>
        </select>

        <?php
    }

    public function port_paye_field_tarra_input( $args ) {
        $options = get_option( 'port_paye_options' );
        ?>

        <p>Anna vaihtoehtoinen marginaali tarralle. Jos käytössä, ylempi kenttä jätetään pois käytöstä. Anna marginaali pelkkinä numeroina.</p>
        <p>A4 oletus 700, A5 oletus 500</p>
        <input type="text" id="port_paye_field_tarra_input" name="port_paye_options[port_paye_field_tarra_input]" value="<?php echo isset( $options['port_paye_field_tarra_input'] ) ? esc_attr( $options['port_paye_field_tarra_input']) : '' ?>" />
        <?php
    }

    public function port_paye_field_tarra_input3( $args ) {
        $options = get_option( 'port_paye_options' );
        ?>

        <p>Osoite, ylämarginaali. Jos ei asetettu, käytetään oletusmarginaalia.</p>
        <input type="text" id="port_paye_field_tarra_input3" name="port_paye_options[port_paye_field_tarra_input3]" value="<?php echo isset( $options['port_paye_field_tarra_input3'] ) ? esc_attr( $options['port_paye_field_tarra_input3']) : '' ?>" />
        <?php
    }

    public function port_paye_field_tarra_input4( $args ) {
        $options = get_option( 'port_paye_options' );
        ?>

        <p>Osoite, vasen marginaali. Jos ei asetettu, käytetään oletusmarginaalia.</p>
        <input type="text" id="port_paye_field_tarra_input4" name="port_paye_options[port_paye_field_tarra_input4]" value="<?php echo isset( $options['port_paye_field_tarra_input4'] ) ? esc_attr( $options['port_paye_field_tarra_input4']) : '' ?>" />
        <?php
    }

    public function port_paye_field_tarra_input2( $args ) {
        $options = get_option( 'port_paye_options' );
        ?>

        <p>Lähettäjän nimi, näkyy osoitetarrassa</p>
        <input type="text" id="port_paye_field_tarra_input2" name="port_paye_options[port_paye_field_tarra_input2]" value="<?php echo isset( $options['port_paye_field_tarra_input2'] ) ? esc_attr( $options['port_paye_field_tarra_input2']) : '' ?>" />
        <?php
    }
    
    public function port_paye_options_page() {
        add_menu_page(
            'Port Paye',
            'Port Paye Asetukset',
            'manage_options',
            'port_paye',
            array( $this, 'port_paye_options_page_html')
        );
    }
    public function sanitize( $input ) {
        $new_input = array();
        if( isset( $input['port_paye_field_tarra_input'] ) )
            $new_input['port_paye_field_tarra_input'] = absint( $input['port_paye_field_tarra_input'] );

        if( isset( $input['port_paye_field_tarra_input2'] ) )
            $new_input['port_paye_field_tarra_input2'] = sanitize_text_field( $input['port_paye_field_tarra_input2'] );

        if( isset( $input['port_paye_field_tarra_input3'] ) )
            $new_input['port_paye_field_tarra_input3'] = sanitize_text_field( $input['port_paye_field_tarra_input3'] );

        if( isset( $input['port_paye_field_tarra_input4'] ) )
            $new_input['port_paye_field_tarra_input4'] = sanitize_text_field( $input['port_paye_field_tarra_input4'] );

        if( isset( $input['port_paye_field_tarra'] ) )
            $new_input['port_paye_field_tarra'] = sanitize_text_field( $input['port_paye_field_tarra'] );

        return $new_input;
    }

    public function port_paye_options_page_html() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error( 'port_paye_messages', 'port_paye_message', __( 'Settings Saved', 'port_paye' ), 'updated' );
        }
        
        settings_errors( 'port_paye_messages' );
        ?>

        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
            <?php
            settings_fields( 'port_paye' );
            do_settings_sections( 'port_paye' );
            submit_button( 'Tallenna asetukset' );
            ?>
            </form>
        </div>

        <?php
    } 
} 

$WB_Priority_Port_Paye_Settings = new WB_Priority_Port_Paye_Settings();