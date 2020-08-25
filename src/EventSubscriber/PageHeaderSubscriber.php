<?php

declare(strict_types = 1);

namespace Drupal\localgov_homepage\EventSubscriber;

use Drupal\localgov_core\Event\PageHeaderDisplayEvent;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Page header event subscriber.
 *
 * Do not display the localgov_page_header_block block for homepage nodes.
 * The localgov_page_header_block displays the page title and we don't want to
 * display any page title on a homepage.
 */
class PageHeaderSubscriber implements EventSubscriberInterface {

  const HOMEPAGE_CONTENT_TYPE = 'localgov_homepage';

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      PageHeaderDisplayEvent::EVENT_NAME => ['setPageHeader', 0],
    ];
  }

  /**
   * Hide page header block.
   */
  public function setPageHeader(PageHeaderDisplayEvent $event) {

    $is_node = $event->getEntity() instanceof NodeInterface;
    $is_homepage_node = $is_node && ($event->getEntity()->bundle() === self::HOMEPAGE_CONTENT_TYPE);
    if ($is_homepage_node) {
      $event->setVisibility(FALSE);
    }
  }

}
