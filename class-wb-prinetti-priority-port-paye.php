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

		add_action( 'admin_footer-edit.php', array( $this, 'WB_Priority_Port_Paye_status' ), 1 );
		add_action( 'load-edit.php', array( $this, 'WB_Priority_Port_Paye' ), 2 );

	}

	/**
	 * Prinetti Lähete Status
	 *
	 * @since 1.0
	 * @access public
	 * @return void
	 */
	public function WB_Priority_Port_Paye_status() {

		global $post_type;
		if($post_type == 'shop_order') {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					// Create Prinetti status
					jQuery('<option>').val('port_paye_priority').text('<?php _e('Tulosta Port-Paye / Priority tarra')?>').appendTo("select[name='action']");
					jQuery('<option>').val('port_paye_priority').text('<?php _e('Tulosta Port-Paye / Priority tarra')?>').appendTo("select[name='action2']");
				});
			</script>
			<?php
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

			if(isset($_REQUEST['post'])) {
				$orderids = array_map('intval', $_REQUEST['post']);
			}

			if( ($action=='port_paye_priority') ) {

				$args = array(
				  'post_type' => 'shop_order',
				  'post_status' => array_keys( wc_get_order_statuses() ),
				  'meta_key' => '_customer_user',
				  'posts_per_page' => '-1'
				);
				$my_query = new WP_Query($args);

				$customer_orders = $my_query->posts;

				$sop_nro = esc_attr( get_option('wb_sop_nro') );

				foreach ($customer_orders as $customer_order) {
					$order = new WC_Order();

					$order->populate($customer_order);
					$orderdata = (array) $order;

					$post_ids = array_map( 'absint', (array) $_REQUEST['post'] );

					foreach ( $post_ids as $post_id ) {

						$order = wc_get_order( $post_id );

						$img = plugin_dir_url( __FILE__ ) . 'assets/img/PRI_black.png';

						echo '<div class="port-paye-address">';
						echo utf8_decode('<br>' .$order->get_formatted_shipping_address() );
						echo '</div>';
						echo '<div class="port-paye-image">';
						echo '<img src="' . $img . '">';
						echo '</div>';
						echo utf8_decode('<br><br>');

						?>
						<style>
							.port-paye-address {
								width: 30%;
								float: left;
							}

							.port-paye-image {
								width: 30%;
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

					break;
				}
				exit();
			}

		}

	}

}

$WB_Priority_Port_Paye = new WB_Priority_Port_Paye();
