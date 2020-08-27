<?php

declare(strict_types = 1);

namespace Drupal\Tests\localgov_homepage\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Functional test for Homepage creation.
 *
 * Fill in the form for the LocalGov Homepage content type and save.
 *
 * @group localgov_homepage
 */
class HomepageAddTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['localgov_homepage'];

  /**
   * Test homepage creation.
   */
  public function testCreateHomepage() {

    $account = $this->drupalCreateUser(['create localgov_homepage content']);
    $this->drupalLogin($account);

    $this->drupalGet('node/add/localgov_homepage');
    $this->assertSession()->statusCodeEquals(200);

    $page = $this->getSession()->getPage();

    $page->fillField('title[0][value]', 'I am a LocalGov homepage :)');

    // Banner.
    $page->fillField('field_banner_colour', '#000000');
    $page->fillField('files[field_banner_0]', \Drupal::service('file_system')->realpath('core/modules/image/sample.png'));

    // CTAs i.e. Icon collection.
    $page->fillField('field_homepage_icons[0][subform][field_title][0][value]', 'Drupal');
    $page->fillField('field_homepage_icons[0][subform][field_icon][0][icon_name]', 'drupal');

    // Service links.
    $page->fillField('field_ia_blocks[0][subform][field_title][0][value]', 'Wordpress');
    $page->fillField('field_ia_blocks[0][subform][field_link][0][uri]', 'https://wordpress.org/');
    $page->fillField('field_ia_blocks[0][subform][field_links][0][title]', 'Plugins');
    $page->fillField('field_ia_blocks[0][subform][field_links][0][uri]', 'https://wordpress.org/plugins/');

    // News CTAs.
    $page->fillField('field_newsroom[0][subform][field_title][0][value]', 'Drupal release news');
    $page->fillField('field_newsroom[0][subform][field_link][0][uri]', 'https://www.drupal.org/project/drupal/releases/');
    $page->fillField('field_newsroom[0][subform][field_summary][0][value]', 'A new Drupal version has been released.');
    $page->fillField('files[field_newsroom_0_subform_field_image_0]', \Drupal::service('file_system')->realpath('core/modules/system/images/no_screenshot.png'));

    $this->submitForm([], 'Save');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->elementNotExists('css', 'div[aria-label="Error message"]');
  }

  /**
   * Theme to use during the functional tests.
   *
   * @var string
   */
  protected $defaultTheme = 'stark';

}
