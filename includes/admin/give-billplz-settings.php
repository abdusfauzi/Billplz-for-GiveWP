<?php

/**
 * Class Give_Billplz_Settings
 *
 * @since 3.1.0
 */
class Give_Billplz_Settings {

  /**
   * @access private
   * @var Give_Billplz_Settings $instance
   */
  static private $instance;

  /**
   * @access private
   * @var string $section_id
   */
  private $section_id;

  /**
   * @access private
   *
   * @var string $section_label
   */
  private $section_label;

  /**
   * Give_Billplz_Settings constructor.
   */
  private function __construct() {

  }

  /**
   * get class object.
   *
   * @return Give_Billplz_Settings
   */
  static function get_instance() {
    if (null === static::$instance) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  /**
   * Setup hooks.
   */
  public function setup_hooks() {

    $this->section_id    = 'billplz';
    $this->section_label = __('Billplz', 'give-billplz');

    if (is_admin()) {
      // Add settings.
      add_action('admin_enqueue_scripts', array($this, 'inject_js'));
      add_filter('give_settings_gateways', array($this, 'add_settings'), 99);
    }
  }

  /**
   * Add setting section.
   *
   * @param array $sections Array of section.
   *
   * @return array
   */
  public function add_section($sections) {
    $sections[$this->section_id] = $this->section_label;

    return $sections;
  }

  /**
   * Add plugin settings.
   *
   * @param array $settings Array of setting fields.
   *
   * @return array
   */
  public function add_settings($settings) {

    $give_billplz_settings = array(
      array(
        'name' => __('Billplz Settings', 'give-billplz'),
        'id'   => 'give_title_billplz',
        'type' => 'give_title',
      ),
      array(
        'name'        => __('API Secret Key', 'give-billplz'),
        'desc'        => __('Enter your API Secret Key, found in your Billplz Account Settings.', 'give-billplz'),
        'id'          => 'billplz_api_key',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('Collection ID', 'give-billplz'),
        'desc'        => __('Enter your Billing Collection ID.', 'give-billplz'),
        'id'          => 'billplz_collection_id',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('X Signature Key', 'give-billplz'),
        'desc'        => __('Enter your X Signature Key, found in your Billplz Account Settings.', 'give-billplz'),
        'id'          => 'billplz_x_signature_key',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('Bill Description', 'give-billplz'),
        'desc'        => __('Enter description to be included in the bill.', 'give-billplz'),
        'id'          => 'billplz_description',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('Reference 1 Label', 'give-billplz'),
        'desc'        => __('Enter reference 1 label.', 'give-billplz'),
        'id'          => 'billplz_reference_1_label',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('Reference 1', 'give-billplz'),
        'desc'        => __('Enter reference 1.', 'give-billplz'),
        'id'          => 'billplz_reference_1',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('Reference 2 Label', 'give-billplz'),
        'desc'        => __('Enter reference 2 label.', 'give-billplz'),
        'id'          => 'billplz_reference_2_label',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'        => __('Reference 2', 'give-billplz'),
        'desc'        => __('Enter reference 2.', 'give-billplz'),
        'id'          => 'billplz_reference_2',
        'type'        => 'text',
        'row_classes' => 'give-billplz-key',
      ),
      array(
        'name'    => __('Billing Fields', 'give-billplz'),
        'desc'    => __('This option will enable the billing details section for Billplz which requires the donor\'s address to complete the donation. These fields are not required by Billplz to process the transaction, but you may have the need to collect the data.', 'give-billplz'),
        'id'      => 'billplz_collect_billing',
        'type'    => 'radio_inline',
        'default' => 'disabled',
        'options' => array(
          'enabled'  => __('Enabled', 'give'),
          'disabled' => __('Disabled', 'give'),
        ),
      ),
    );

    return array_merge($settings, $give_billplz_settings);
  }

  public function inject_js($hook) {
    if ('post.php' === $hook || $hook === 'post-new.php') {
      wp_enqueue_script('give_billplz_each_form', GIVE_BILLPLZ_PLUGIN_URL . '/myscript.js');
    }
  }
}

Give_Billplz_Settings::get_instance()->setup_hooks();