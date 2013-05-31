<?php if(isset($cart_messages) && count($cart_messages) > 0) { ?>
	<?php foreach((array)$cart_messages as $cart_message) { ?>
	  <span class="cart_message"><?php echo $cart_message; ?></span>
	<?php } ?>
<?php } ?>

<?php if(wpsc_cart_item_count() > 0): ?>
    <div class="shoppingcart">
	<table>
		<thead>
			<tr>
				<td id="product" colspan='2'><?php _e('Product', 'wpsc'); ?></td>
				<td id="quantity"><?php _e('Qty', 'wpsc'); ?></td>
				<td id="price"><?php _e('Price', 'wpsc'); ?></td>
	            <td id="remove">&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		<?php while(wpsc_have_cart_items()): wpsc_the_cart_item(); ?>
			<tr>
					<td colspan='2' class='product-name'><a href="<?php echo wpsc_cart_item_url(); ?>"><?php echo wpsc_cart_item_name(); ?></a></td>
					<td><?php echo wpsc_cart_item_quantity(); ?></td>
					<td><?php echo wpsc_cart_item_price(); ?></td>
                    <td class="cart-widget-remove"><form action="" method="post" class="adjustform">
					<input type="hidden" name="quantity" value="0" />
					<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
					<input type="hidden" name="wpsc_update_quantity" value="true" />
					<input class="remove_button" type="submit" />
				</form></td>
			</tr>	
		<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr class="cart-widget-total">
				<td class="cart-widget-count">
					<?php printf( _n('%d item', '%d items', wpsc_cart_item_count(), 'wpsc'), wpsc_cart_item_count() ); ?>
				</td>
				<td class="pricedisplay checkout-subtotal" colspan='4'>
					<?php _e('Total', 'wpsc'); ?>: <?php echo wpsc_cart_total_widget(false,false,false);?><br />
				</td>
			</tr>
			<tr>
				<td id='cart-widget-links' colspan="5">
					<p class="button red"><a target="_parent" href="<?php echo get_option('shopping_cart_url'); ?>" title="<?php _e('Checkout', 'wpsc'); ?>" class="gocheckout"><?php _e('Checkout', 'wpsc'); ?></a></p>
					<form action="" method="post" class="wpsc_empty_the_cart">
						<input type="hidden" name="wpsc_ajax_action" value="empty_cart" />
                        <p class="button fr">
                        	<a target="_parent" href="<?php echo htmlentities(add_query_arg('wpsc_ajax_action', 'empty_cart', remove_query_arg('ajax')), ENT_QUOTES, 'UTF-8'); ?>" class="emptycart" title="<?php _e('Empty Your Cart', 'wpsc'); ?>">
                            <?php _e('Clear cart', 'wpsc'); ?>
                        	</a> 
                        </p>                                                                                   
					</form>
				</td>
			</tr>
		</tfoot>
	</table>
	</div><!--close shoppingcart-->		
<?php else: ?>
	<div class="empty">
    	<p><strong><?php _e('Your shopping cart is empty.', 'wpsc'); ?></strong></p>
    	<p><small><?php _e('Please add an item to the Shopping Cart.', 'wpsc'); ?></small></p>
    </div>
<?php endif; ?>

<?php
wpsc_google_checkout();


?>