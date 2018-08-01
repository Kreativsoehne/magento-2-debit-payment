<?php
namespace kreativsoehne\DebitPayment\Model\Payment;

use Magento\Framework\DataObject;

class Debit extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * Payment Method features
     *
     * @var bool
     */
    protected $_canAuthorize = true;

    /**
     * Payment code name
     *
     * @var string
     */
    protected $_code = 'debit';

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );
        $this->_customerSession = $customerSession;
        $this->_scopeConfig = $scopeConfig;
        $this->_messageManager = $messageManager;
    }

    /**
     * Check whether method is available or not for specific customer group
     *
     * @param \Magento\Quote\Api\Data\CartInterface|\Magento\Quote\Model\Quote|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {

        if (!parent::isAvailable($quote)) {
            return false;
        }

        // get the user group ids which are accepted for paying with this payment method
        $acceptedGroups = explode(",", $this->_scopeConfig->getValue('payment/debit/specificcustomergroup', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));

        // get the current user's user group id
        $currentGroupId = $this->_customerSession->getCustomer()->getGroupId();

        $checkResult = new DataObject();
        $checkResult->setData('is_available', in_array($currentGroupId, $acceptedGroups));

        // for future use in observers
        $this->_eventManager->dispatch(
            'payment_method_is_active',
            [
                'result' => $checkResult,
                'method_instance' => $this,
                'quote' => $quote
            ]
        );

        /*
        if ($checkResult->getData('is_available')){
            $this->_messageManager->addNotice("Lastschrift geht");
        } else {
            $this->_messageManager->addNotice("Lastschrift geht NICHT");
        }
        */

        return $checkResult->getData('is_available');
    }
}
