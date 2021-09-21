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
     * @var mixed[]
     */
    protected $vars;

    /**
     * Template options
     *
     * @var mixed[]
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
     * @param mixed[] $vars
     * @return void
     */
    public function setTemplateVars(array $vars)
    {
        $this->vars = $vars;
    }

    /**
     * Set email template options
     *
     * @param mixed[] $options
     * @return void
     */
    public function setTemplateOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Retrieve email template variables
     *
     * @return mixed[]
     */
    public function getTemplateVars()
    {
        return $this->vars;
    }

    /**
     * Retrieve email template options
     *
     * @return mixed[]
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
