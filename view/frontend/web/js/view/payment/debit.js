define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'debit',
                component: 'kreativsoehne_DebitPayment/js/view/payment/method-renderer/debit-method'
            }
        );
        return Component.extend({});
    }
);
