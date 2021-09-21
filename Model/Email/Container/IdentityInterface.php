<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\ReviewAlert\Model\Email\Container;

/**
 * Email identity interface
 */
interface IdentityInterface
{
    /**
     * Check functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Retrieve email copy to list
     *
     * @return string[]|bool
     */
    public function getEmailCopyTo();

    /**
     * Retrieve copy method
     *
     * @return string
     */
    public function getCopyMethod();

    /**
     * Retrieve template id
     *
     * @return string
     */
    public function getTemplateId();

    /**
     * Retrieve email identity
     *
     * @return string
     */
    public function getEmailIdentity();

    /**
     * Retrieve user email
     *
     * @return string
     */
    public function getUserEmail();

    /**
     * Retrieve store
     *
     * @return \Magento\Store\Api\Data\StoreInterface
     */
    public function getStore();
}
