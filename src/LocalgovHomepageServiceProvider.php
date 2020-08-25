<?php

declare(strict_types = 1);

namespace Drupal\localgov_homepage;

use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Programmatically declare the localgov_homepage.page_header_display service.
 *
 * The localgov_homepage.page_header service is an event subscriber for
 * the Drupal\localgov_core\Event\PageHeaderDisplayEvent event.  Instead of
 * declaring this event subscriber through localgov_homepage.services.yml, we
 * register it here conditionally when the localgov_core module is available.
 *
 * @see https://www.drupal.org/docs/drupal-apis/services-and-dependency-injection/altering-existing-services-providing-dynamic
 * @see https://symfony.com/doc/3.4/components/dependency_injection.html
 * @see Drupal\paragraphs\ParagraphsServiceProvider
 */
class LocalgovHomepageServiceProvider implements ServiceProviderInterface {

  const EVENT_SUBSCRIBER_SERVICE_ID = 'localgov_homepage.page_header';
  const EVENT_SUBSCRIBER_SERVICE_CLASS = 'Drupal\localgov_homepage\EventSubscriber\PageHeaderSubscriber';
  const LOCALGOV_CORE_EVENT_CLASS = 'Drupal\localgov_core\Event\PageHeaderDisplayEvent';

  /**
   * {@inheritdoc}
   *
   * Is the localgov_core module available?  Then register our page header
   * display event subscriber.
   */
  public function register(ContainerBuilder $container) {

    $has_no_localgov_core = !class_exists(self::LOCALGOV_CORE_EVENT_CLASS);
    if ($has_no_localgov_core) {
      return;
    }

    $event_subscriber_service_def = new Definition(self::EVENT_SUBSCRIBER_SERVICE_CLASS);
    $event_subscriber_service_def->addTag('event_subscriber');
    $container->setDefinition(self::EVENT_SUBSCRIBER_SERVICE_ID, $event_subscriber_service_def);
  }

}
