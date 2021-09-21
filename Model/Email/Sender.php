<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\ReviewAlert\Model\Email;

use Psr\Log\LoggerInterface;
use Magento\Framework\Registry;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Review\Model\Review;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory;
use Eriocnemis\ReviewAlert\Model\Email\Container\IdentityInterface;
use Eriocnemis\ReviewAlert\Model\Email\Container\Template;

/**
 * Email sender
 */
class Sender
{
    /**
     * Core registry
     *
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Vote collection factory
     *
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Email sender builder factory
     *
     * @var SenderBuilderFactory
     */
    private $senderBuilderFactory;

    /**
     * Catalog product image helper
     *
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * Template container
     *
     * @var Template
     */
    private $template;

    /**
     * Identity container
     *
     * @var IdentityInterface
     */
    private $identity;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize sender
     *
     * @param Registry $coreRegistry
     * @param Template $template
     * @param IdentityInterface $identity
     * @param SenderBuilderFactory $senderBuilderFactory
     * @param CollectionFactory $collectionFactory
     * @param ImageHelper $imageHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        Registry $coreRegistry,
        Template $template,
        IdentityInterface $identity,
        SenderBuilderFactory $senderBuilderFactory,
        CollectionFactory $collectionFactory,
        ImageHelper $imageHelper,
        LoggerInterface $logger
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->template = $template;
        $this->identity = $identity;
        $this->senderBuilderFactory = $senderBuilderFactory;
        $this->collectionFactory = $collectionFactory;
        $this->imageHelper = $imageHelper;
        $this->logger = $logger;
    }

    /**
     * Send review email if it is enabled in configuration
     *
     * @param Review $review
     * @return bool
     */
    public function send(Review $review)
    {
        if (!$this->identity->isEnabled()) {
            return false;
        }

        $this->prepareTemplate($review);
        $sender = $this->senderBuilderFactory->create(
            [
                'template' => $this->template,
                'identity' => $this->identity
            ]
        );

        try {
            $sender->send();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }

        try {
            $sender->sendCopyTo();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Populate review email template
     *
     * @param Review $review
     * @return void
     */
    private function prepareTemplate(Review $review)
    {
        $this->template->setTemplateId($this->identity->getTemplateId());
        $this->template->setTemplateOptions($this->getTemplateOptions());
        $this->template->setTemplateVars($this->getTemplateVars($review));
    }

    /**
     * Retrieve template options
     *
     * @return mixed[]
     */
    private function getTemplateOptions()
    {
        return [
            'area' => 'frontend',
            'store' => $this->identity->getStore()->getId()
        ];
    }

    /**
     * Retrieve template vars
     *
     * @param Review $review
     * @return mixed[]
     */
    private function getTemplateVars(Review $review)
    {
        return [
            'review' => $review,
            'store' => $this->identity->getStore(),
            'votes' => $this->getVoteCollection($review),
            'product' => $this->getProduct()
        ];
    }

    /**
     * Retrieve current product
     *
     * @return \Magento\Catalog\Model\Product
     */
    private function getProduct()
    {
        $product = $this->coreRegistry->registry('current_product');
        $product->setHref($product->getUrlModel()->getUrl($product));
        $product->setSrc($this->imageHelper->init($product, 'small_image', ['type'=>'small_image'])
            ->getUrl());

        return $product;
    }

    /**
     * Retrieve vote collection
     *
     * @param Review $review
     * @return \Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection
     */
    private function getVoteCollection(Review $review)
    {
        $votes = $this->collectionFactory->create();
        $votes->setReviewFilter($review->getId())
            ->addRatingInfo()->addOptionInfo()->setOrder('position');

        return $votes;
    }
}
