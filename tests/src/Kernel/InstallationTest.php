<?php

namespace Drupal\Tests\localgov_homepage\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Module installation test.
 *
 * @group localgov_homepage
 */
class InstallationTest extends KernelTestBase {

  /**
   * Module installation test.
   *
   * Should add the localgov_homepage content type.
   */
  public function testInstallation() {

    $this->container->get('module_installer')->install(['user']);
    $this->container->get('module_installer')->install(['localgov_homepage']);

    $available_content_types = $this->container->get('entity_type.bundle.info')->getBundleInfo('node');
    $has_localgov_homepage = array_key_exists('localgov_homepage', $available_content_types);
    $this->assertTrue($has_localgov_homepage);
  }

}
