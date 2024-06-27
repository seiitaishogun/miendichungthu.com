'use strict';

var Cart = {
    getNumberOfCart: function() {
        $.get(CNV.baseUrl + '/cart/ajax?action=count_number_of_cart', function (data) {
            if (data && data.count) {
                $('.count_cart').html(data.count);
            }
        })
    },
    addToCart: function (id, quantity, create) {
        var data,
            obj = this;

        if (typeof quantity === "undefined") {
            quantity = $('input[name=quantity][data-id=' + id +']').val() || 0;
        }
        quantity = parseInt(quantity);

        data = {
            id: id,
            quantity: quantity,
            create: create || 0
        };

        $.get(CNV.baseUrl + '/cart/ajax?action=add_to_cart&' + $.param(data), function (data) {
            if (data && data.status === 200) {
                obj.getNumberOfCart();
                toastr.success(data.message, CNV.language.success);
            } else {
                toastr.warning(data.message, CNV.language.warning);
            }
        }).fail(function () {
            toastr.error(CNV.language.internet_error, CNV.language.error);
        });
    },
    removeFromCart: function (id) {``
        $.get(CNV.baseUrl + '/cart/ajax?action=remove_from_cart&id=' + id, function (data) {
                reload_page();
        }).fail(function () {
            toastr.error(CNV.language.internet_error, CNV.language.error);
        });
    },
    changeQuantity: function () {
        var obj = this;
        $('.qty').on('change', function (event) {
            var id = $(this).data('id'),
                singlePrice = $('.single-price[data-id='+ id +']'),
                price = $('.total_price[data-id='+ id +']'),
                quantity = $(this).val(),
                newPrice = singlePrice.data('value') * quantity,
                subtotal = $('.subtotal_all');

            event.preventDefault();
            obj.addToCart(id, quantity, true);

            price.html(number_format(newPrice));
            price.data('value', newPrice);

            var total = 0;
            $('.total_price').each(function () {
                total += parseFloat($(this).data('value'));
            });
            subtotal.data('value', total);
            subtotal.html(number_format(total));

        });
    },
    init: function () {
        this.getNumberOfCart();
        this.changeQuantity();
    }
};

Cart.init();