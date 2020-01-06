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
				'name'      => __( 'Port Paye Priority', 'wb-port_paye' ),
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

			foreach ( $post_ids as $post_id ) {
				$order = wc_get_order( $post_id );

				$img = plugin_dir_url( __FILE__ ) . '../assets/img/PRI_black.png';

				echo '<div class="port-paye-address">';
				echo '<br>' .$order->get_formatted_shipping_address();
				echo '</div>';
				echo '<div class="port-paye-image">';
				echo '<img src="' . $img . '">';
				echo '</div>';
				echo '<br><br>';

				$options = get_option( 'port_paye_options' );
				
				$tarra_koko = isset( $options['port_paye_field_tarra'] ) ? $options['port_paye_field_tarra'] : ( 'a4' );

				if($tarra_koko == 'a4') {
					$set_width = '700px';
				} else {
					$set_width = '500px';
				}

				$options = get_option( 'port_paye_options' );
				if( isset( $options['port_paye_field_tarra_input'] ) && $options['port_paye_field_tarra_input'] > 0 ) {
					$set_width = $options['port_paye_field_tarra_input'] . 'px';
				}
				?>
				<style>
					.port-paye-address {
						width: <?php echo $set_width; ?>;
						float: left;
					}

					.port-paye-image {
						width: 90.708661417px;
						float: left;
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
