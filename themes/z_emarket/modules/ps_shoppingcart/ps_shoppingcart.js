$(window).on('load', function() {
  prestashop.blockcart = prestashop.blockcart || {};

  var showModal = prestashop.blockcart.showModal || function (modal) {
    var $body = $('body');
    $body.append(modal);
    $body.one('click', '#blockcart-modal', function (event) {
      if (event.target.id === 'blockcart-modal') {
        $(event.target).remove();
      }
    });
  };

  prestashop.on(
    'updateCart',
    function (event) {
      var refreshURL = $('.blockcart').data('refresh-url');
      var requestData = {};

      if (event && event.reason && typeof event.resp !== 'undefined' && !event.resp.hasError) {
        requestData = {
          id_customization: event.reason.idCustomization,
          id_product_attribute: event.reason.idProductAttribute,
          id_product: event.reason.idProduct,
          action: event.reason.linkAction
        };
      }
      if (event && event.resp && event.resp.hasError) {
        prestashop.emit('showErrorNextToAddtoCartButton', { errorMessage: event.resp.errors.join('<br/>')});
      }

      $.post(refreshURL, requestData).then(function (resp) {
        $('.blockcart .cart-header').replaceWith($(resp.preview).find('.blockcart .cart-header'));
        $('[data-sticky-cart]').html($('[data-header-cart-source]').html());

        if (prestashop.page.page_name !== 'checkout' && prestashop.page.page_name !== 'cart') {
          $('[data-shopping-cart-source]').replaceWith($(resp.preview).find('[data-shopping-cart-source]'));

          if ($('[data-st-cart]').length && typeof(varPSAjaxCart) !== 'undefined' && varPSAjaxCart) {
            $('#js-cart-sidebar').html($('[data-shopping-cart-source]').html());
            $('[data-shopping-cart-source]').addClass('js-hidden');
            $.each($('#js-cart-sidebar input[name="product-sidebar-quantity-spin"]'), function (index, spinner) {
              $(spinner).makeTouchSpin();

              $(spinner).on('change', function () {
                $(spinner).trigger('focusout');
              });
            });
            if (resp.modal) {
              $('html').addClass('st-effect-right st-menu-open');

              setTimeout(function() {
                if (prestashop.page.page_name == 'product') {
                  prestashop.emit('updateProduct', {});
                }
              }, 500);
            }
          } else {
            if (typeof(varPSAjaxCart) !== 'undefined' && varPSAjaxCart && resp.modal) {
              showModal(resp.modal);
            }
          }
        }

        $('.js-ajax-add-to-cart').removeClass('disabled');
        $('[data-button-action="add-to-cart"]').removeClass('disabled');
        $('.js-cart-update-voucher, .js-cart-update-quantity').fadeOut();
      }).fail(function (resp) {
        prestashop.emit('handleError', {eventType: 'updateShoppingCart', resp: resp});
      });
    }
  );
});
