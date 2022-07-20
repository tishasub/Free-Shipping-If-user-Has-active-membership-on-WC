/**
 * Hide shipping methods when free shipping is available for active membership
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function ts_hide_shipping_when_free_is_available( $rates ) {
// get all active memberships for a user; 
// returns an array of active user membership objects
$user_id = get_current_user_id();

$args = array( 
    'status' => array( 'active', 'complimentary', 'pending' ),
);  

$active_memberships = wc_memberships_get_user_memberships( $user_id, $args );
  $free = array();
  foreach ( $rates as $rate_id => $rate ) {
    if ( 'free_shipping' === $rate->get_method_id() && !empty( $active_memberships ) ) {
      $free[ $rate_id ] = $rate;
    }
  }
  return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'ts_hide_shipping_when_free_is_available', 100 );
