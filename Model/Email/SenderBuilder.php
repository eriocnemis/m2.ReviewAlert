<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\ReviewAlert\Model\Email;

use Magento\Framework\Mail\Template\TransportBuilder;
use Eriocnemis\ReviewAlert\Model\Email\Container\IdentityInterface;
use Eriocnemis\ReviewAlert\Model\Email\Container\Template;

/**
 * Email sender builder
 */
class SenderBuilder
{
    /**
     * Template container
     *
     * @var Template
     */
    protected $template;

    /**
     * Identity container
     *
     * @var IdentityInterface
     */
    protected $identity;

    /**
     * Email transport builder
     *
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * Initialize builder
     *
     * @param Template $template
     * @param IdentityInterface $identity
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        Template $template,
        IdentityInterface $identity,
        TransportBuilder $transportBuilder
    ) {
        $this->template = $template;
        $this->identity = $identity;
        $this->transportBuilder = $transportBuilder;
    }

    /**
     * Prepare and send email message
     *
     * @return void
     */
    public function send()
    {
        $this->configureEmailTemplate();
        $this->transportBuilder->addTo(
            $this->identity->getUserEmail()
        );

        $copyTo = $this->identity->getEmailCopyTo();
        if (false !== $copyTo && $this->identity->getCopyMethod() == 'bcc') {
            foreach ((array)$copyTo as $email) {
                $this->transportBuilder->addBcc($email);
            }
        }

        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
    }

    /**
     * Prepare and send copy email message
     *
     * @return void
     */
    public function sendCopyTo()
    {
        $copyTo = $this->identity->getEmailCopyTo();

        if (false !== $copyTo && $this->identity->getCopyMethod() == 'copy') {
            $this->configureEmailTemplate();
            foreach ((array)$copyTo as $email) {
                $this->transportBuilder->addTo($email);
                $transport = $this->transportBuilder->getTransport();
                $transport->sendMessage();
            }
        }
    }

    /**
     * Configure email template
     *
     * @return void
     */
    protected function configureEmailTemplate()
    {
        $this->transportBuilder->setTemplateIdentifier($this->template->getTemplateId());
        $this->transportBuilder->setTemplateOptions($this->template->getTemplateOptions());
        $this->transportBuilder->setTemplateVars($this->template->getTemplateVars());
        $this->transportBuilder->setFromByScope(
            $this->identity->getEmailIdentity(),
            $this->identity->getStore()->getId()
        );
    }
}
