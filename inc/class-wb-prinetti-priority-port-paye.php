<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WB_Priority_Port_Paye Class
 *
 * @class WB_Priority_Port_Paye
 * @version	1.0
 * @since 1.0
 */

class WB_Priority_Port_Paye {

	/**
	 * Hooks & Filters
	 *
	 * @since 1.0
	 * @public
	 */
	public function __construct () {
		add_filter( 'woocommerce_admin_order_actions', array( $this, 'port_paye_woo_actions'), 10, 1);
		add_action( 'load-edit.php', array( $this, 'WB_Priority_Port_Paye' ), 2 );
		add_action( 'admin_footer-edit.php', array( $this, 'wb_port_paye_order_status' ), 1 );
	}

	/**
	 * Mass actions
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function wb_port_paye_order_status() {

		global $post_type;
		if($post_type == 'shop_order') {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					// Create port_paye status
					jQuery('<option>').val('port_paye_priority').text('<?php _e('Port Paye', 'port_paye')?>').appendTo("select[name='action']");
					jQuery('<option>').val('port_paye_priority').text('<?php _e('Port Paye', 'port_paye')?>').appendTo("select[name='action2']");
				});
			</script>
			<?php
		}

	}

	/**
	 * Row actions
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function port_paye_woo_actions($array) {

		global $post;
		global $post_type;

		if($post_type == 'shop_order') {
			$order = new WC_Order($post->ID);			

			$array['smartship'] = array(
				'url'       => admin_url("edit.php?post=$post->ID&post_type=shop_order&action=port_paye_priority"),
				'name'      => __( 'Port Paye Priority', 'port_paye' ),
				'action'    => "port_paye_priority",
				'target'    => "new",
			);

			return $array;
		}

	}

	/**
	 * Fire-up actions after list is recuired
	 *
	 * @since 1.0
	 * @static
	 * @return void
	 */
	public static function WB_Priority_Port_Paye() {

		// Käynnistetään Custom Order Status
		global $typenow;
		$post_type = $typenow;

		if($post_type == 'shop_order') {
			$wp_list_table = _get_list_table('WP_Posts_List_Table');
			$action = $wp_list_table->current_action();

			$allowed_actions = array("port_paye_priority");

			if(!in_array($action, $allowed_actions)) return;

			$post_ids = array_map( 'absint', (array) $_REQUEST['post'] );

			$options = get_option( 'port_paye_options' );
				
			$tarra_koko = isset( $options['port_paye_field_tarra'] ) ? $options['port_paye_field_tarra'] : ( 'a4' );

			$sender     	   = isset( $options['port_paye_field_tarra_input2'] ) ? $options['port_paye_field_tarra_input2'] : '';
			$store_address     = get_option( 'woocommerce_store_address' );
			$store_address_2   = get_option( 'woocommerce_store_address_2' );
			$store_city        = get_option( 'woocommerce_store_city' );
			$store_postcode    = get_option( 'woocommerce_store_postcode' );

			foreach ( $post_ids as $post_id ) {
				$order = wc_get_order( $post_id );

				$img = plugin_dir_url( __FILE__ ) . '../assets/img/PRI_black.png';

				echo '<div class="port-paye-wrap">';
					echo '<div class="port-paye-sender-address">';
						echo '<br>' . $sender;
						echo '<br>' . $store_address;
						echo '<br>' . $store_city;
						echo '<br>' . $store_postcode;
					echo '</div>';

					echo '<div class="port-paye-address">';
						echo '<br>' .$order->get_formatted_shipping_address();
					echo '</div>';

					echo '<div class="port-paye-image">';
						echo '<img src="' . $img . '">';
					echo '</div>';
					echo '<br><br>';

				echo '</div>';

				if($tarra_koko == 'a4') {
					$stamp_left_margin = '700px';
					$address_top_margin = '20px';
					$address_left_margin = '320px';
					$total_height = '864px';
				} else {
					$stamp_left_margin = '500px';
					$address_top_margin = '20px';
					$address_left_margin = '220px';
					$total_height = '595px';
				}

				$options = get_option( 'port_paye_options' );
				if( isset( $options['port_paye_field_tarra_input'] ) && $options['port_paye_field_tarra_input'] > 0 ) {
					$stamp_left_margin = $options['port_paye_field_tarra_input'] . 'px';
				}

				if( isset( $options['port_paye_field_tarra_input3'] ) && $options['port_paye_field_tarra_input3'] > 0 ) {
					$address_top_margin = $options['port_paye_field_tarra_input3'] . 'px';
				}

				if( isset( $options['port_paye_field_tarra_input4'] ) && $options['port_paye_field_tarra_input4'] > 0 ) {
					$address_left_margin = $options['port_paye_field_tarra_input4'] . 'px';
				}

				if( isset( $options['port_paye_field_tarra_input5'] ) && $options['port_paye_field_tarra_input5'] > 0 ) {
					$total_height = $options['port_paye_field_tarra_input5'] . 'px';
				}

				if( isset( $options['port_paye_field_tarra_input4'] ) && $options['port_paye_field_tarra_input4'] > 0 ) {
					$address_left_margin = $options['port_paye_field_tarra_input4'] . 'px';
				}
				?>
				<style>
					.port-paye-wrap {
						width: 100%;
						height: <?php echo $total_height ?>;
						display: table;
						position: relative;
						padding: 20px;
					}

					.port-paye-sender-address {
						position: absolute;
						top: 0px;
						left: 0px;
						font-size: 13px;
					}

					.port-paye-address {
						position: absolute;
						top: <?php echo $address_top_margin ?>;
						left: <?php echo $address_left_margin ?>;
					}

					.port-paye-image {
						width: 90.708661417px;
						position: absolute;
						top: 0px;
						left: <?php echo $stamp_left_margin ?>;
					}

					.port-paye-image img {
						width: 90.708661417px;
						height: auto;
					}

					small { font-size: 15px; }
				</style>
			<?php
			}
		
		exit();
		}

	}

}

$WB_Priority_Port_Paye = new WB_Priority_Port_Paye();
