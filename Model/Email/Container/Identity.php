<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\ReviewAlert\Model\Email\Container;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Email identity
 */
class Identity implements IdentityInterface
{
    /**
     * Copy method config path
     */
    const XML_PATH_COPY_METHOD = 'admin/eriocnemis_review_alert/copy_method';

    /**
     * Copy to config path
     */
    const XML_PATH_COPY_TO = 'admin/eriocnemis_review_alert/copy_to';

    /**
     * Receiver config path
     */
    const XML_PATH_RECEIVER = 'admin/eriocnemis_review_alert/receiver';

    /**
     * Identity config path
     */
    const XML_PATH_IDENTITY = 'admin/eriocnemis_review_alert/identity';

    /**
     * Template config path
     */
    const XML_PATH_TEMPLATE = 'admin/eriocnemis_review_alert/template';

    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = 'admin/eriocnemis_review_alert/enabled';

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Initialize identity
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Check functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->getStore()->getId()
        );
    }

    /**
     * Retrieve email copy to list
     *
     * @return string[]|bool
     */
    public function getEmailCopyTo()
    {
        $data = $this->getConfigValue(self::XML_PATH_COPY_TO);
        if (!empty($data)) {
            return explode(',', $data);
        }
        return false;
    }

    /**
     * Retrieve copy method
     *
     * @return string
     */
    public function getCopyMethod()
    {
        return $this->getConfigValue(self::XML_PATH_COPY_METHOD);
    }

    /**
     * Retrieve template id
     *
     * @return string
     */
    public function getTemplateId()
    {
        return $this->getConfigValue(self::XML_PATH_TEMPLATE);
    }

    /**
     * Retrieve email identity
     *
     * @return string
     */
    public function getEmailIdentity()
    {
        return $this->getConfigValue(self::XML_PATH_IDENTITY);
    }

    /**
     * Retrieve user email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->getConfigValue(self::XML_PATH_RECEIVER);
    }

    /**
     * Retrieve store configuration value
     *
     * @param string $path
     * @param int $storeId
     * @return string
     */
    protected function getConfigValue($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId ?? $this->getStore()->getId()
        );
    }

    /**
     * Retrieve store
     *
     * @return \Magento\Store\Api\Data\StoreInterface
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
}
