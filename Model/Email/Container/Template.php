<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\ReviewAlert\Model\Email\Container;

/**
 * Email template
 */
class Template
{
    /**
     * Template variables
     *
     * @var array
     */
    protected $vars;

    /**
     * Template options
     *
     * @var array
     */
    protected $options;

    /**
     * Template id
     *
     * @var string
     */
    protected $templateId;

    /**
     * Set email template variables
     *
     * @param array $vars
     * @return void
     */
    public function setTemplateVars(array $vars)
    {
        $this->vars = $vars;
    }

    /**
     * Set email template options
     *
     * @param array $options
     * @return void
     */
    public function setTemplateOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Retrieve email template variables
     *
     * @return array
     */
    public function getTemplateVars()
    {
        return $this->vars;
    }

    /**
     * Retrieve email template options
     *
     * @return array
     */
    public function getTemplateOptions()
    {
        return $this->options;
    }

    /**
     * Set email template id
     *
     * @param string $templateId
     * @return void
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * Retrieve email template id
     *
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }
}
