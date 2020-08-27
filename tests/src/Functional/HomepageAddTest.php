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

    $account = $this->drupalCreateUser(['create localgov_homepage content', 'view own unpublished content']);
    $this->drupalLogin($account);

    $this->drupalGet('node/add/localgov_homepage');
    $this->assertSession()->statusCodeEquals(200);

    $page = $this->getSession()->getPage();

    $page->fillField('title[0][value]', 'I am a LocalGov homepage :)');

    // Banner.
    $page->fillField('localgov_homepage_banner_colour', '#000000');
    $page->fillField('files[localgov_homepage_banner_0]', \Drupal::service('file_system')->realpath('core/modules/image/sample.png'));

    // CTAs i.e. Icon collection.
    $page->fillField('localgov_homepage_labelled_icons[0][subform][localgov_labelled_icons_title][0][value]', 'Drupal');
    $page->fillField('localgov_homepage_labelled_icons[0][subform][localgov_labelled_icons_icon][0][icon_name]', 'drupal');

    // Service links.
    $page->fillField('localgov_homepage_ia_blocks[0][subform][localgov_ia_blocks_title][0][value]', 'Wordpress');
    $page->fillField('localgov_homepage_ia_blocks[0][subform][localgov_ia_blocks_link][0][uri]', 'https://wordpress.org/');
    $page->fillField('localgov_homepage_ia_blocks[0][subform][localgov_ia_blocks_links][0][title]', 'Plugins');
    $page->fillField('localgov_homepage_ia_blocks[0][subform][localgov_ia_blocks_links][0][uri]', 'https://wordpress.org/plugins/');

    // News CTAs.
    $page->fillField('localgov_homepage_newsroom[0][subform][localgov_newsroom_teasers_title][0][value]', 'Drupal release news');
    $page->fillField('localgov_homepage_newsroom[0][subform][localgov_newsroom_teasers_link][0][uri]', 'https://www.drupal.org/project/drupal/releases/');
    $page->fillField('localgov_homepage_newsroom[0][subform][localgov_newsroom_teasers_summar][0][value]', 'A new Drupal version has been released.');
    $page->fillField('files[localgov_homepage_newsroom_0_subform_localgov_newsroom_teasers_image_0]', \Drupal::service('file_system')->realpath('core/modules/system/images/no_screenshot.png'));

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
