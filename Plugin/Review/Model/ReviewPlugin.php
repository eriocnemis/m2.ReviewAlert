<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\ReviewAlert\Plugin\Review\Model;

use Magento\Review\Model\Review;
use Eriocnemis\ReviewAlert\Model\Email\Sender;

/**
 * Review model plugin
 */
class ReviewPlugin
{
    /**
     * Email sender
     *
     * @var Sender
     */
    protected $sender;

    /**
     * Initialize plugin
     *
     * @param Sender $sender
     */
    public function __construct(
        Sender $sender
    ) {
        $this->sender = $sender;
    }

    /**
     * Aggregate reviews
     *
     * @param Review $review
     * @param array $result
     * @return array
     */
    public function afterAggregate(Review $review, $result)
    {
        if ($review->isObjectNew()) {
            $this->sender->send($review);
        }
        return $result;
    }
}
