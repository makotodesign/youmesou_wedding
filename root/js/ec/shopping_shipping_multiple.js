/*--------------------------------------------------------------

	shopping_shipping_multiple

	@memo

---------------------------------------------------------------*/

jQuery(function ($) {
	let listIndex, $shippingListSet, $listFirst, $listClone;
	function eventify() {
		$('[data-role=add]').click(function () {
			i = $(this).data('index');
			listIndex = 0;
			$shippingListSet = $('#multiple_' + i + '_shipping_list_set');
			$listFirst = $('#multiple_' + i + '_shipping_list_0');
			$listClone = $listFirst.clone();
			listIndex = $shippingListSet.find('.shipping_list').length;
			console.log('#multiple_' + i + '_shipping_list_set');
			console.log(listIndex);
			listIndex = parseInt(listIndex) + 1;
			// リストID
			$listClone.attr('id', 'multiple_' + i + '_shipping_list_' + listIndex).data('listindex', listIndex);
			// お届け先 select
			$('.shipping_address_select select', $listClone)
				.attr('name', 'form[shipping_multiple][' + i + '][shipping][' + listIndex + '][customer_address]')
				.attr('id', 'form_shipping_multiple_' + i + '_shipping_' + listIndex + '_customer_address');
			// 数量 input
			$('.shipping_quantity_input input', $listClone)
				.attr('name', 'form[shipping_multiple][' + i + '][shipping][' + listIndex + '][quantity]')
				.attr('id', 'form_shipping_multiple_' + i + '_shipping_' + listIndex + '_quantity');
			// shipping_address
			$('.shipping_address', $listClone).attr('id', 'multiple_' + i + '_shipping_address_' + listIndex);
			// shipping_quantity
			$('.shipping_quantity', $listClone).attr('id', 'multiple_' + i + '_shipping_quantity_' + listIndex + '');
			// button_delete
			$('button', $listClone)
				.attr('id', 'multiple_' + i + '_button_delete_' + listIndex + '')
				.data('listindex', listIndex)
				.show();
			$listClone.insertBefore($('#multiple_' + i + '_button_add').parent());
		});
		$(document).on('click', '[data-role=delete]', function () {
			$('#multiple_' + $(this).data('index') + '_shipping_list_' + $(this).data('listindex')).remove();
		});
	}

	function setup() {}

	$(function () {
		eventify();
		setup();
	});
});
