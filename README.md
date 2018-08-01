# magento-2-debit-payment
A simple Magento 2 Extension for debit payment, restrictable for user groups.

## installation
    1. $ composer require kreativsoehne/magento-2-debit-payment
    2. $ ./bin/magento module:enable kreativsoehne_DebitPayment
    3. $ ./bin/magento setup:upgrade
	4. $ ./bin/magento setup:di:compile
    5. Profit.

## usage
To activate the debit payment method, navigate to:

	Shops -> Settings -> Configuration -> Sales -> Payment Methods -> Debit

You can set a custom title within the checkout process and define which user groups are able to use the payment method.

## Notice:
This extension is NOT able to ask for IBAN code. It just wraps a simple offline payment method for customers already have granted you debit payment access.