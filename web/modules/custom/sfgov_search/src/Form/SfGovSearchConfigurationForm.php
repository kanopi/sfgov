<?php

namespace Drupal\sfgov_search\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Defines a form that configures sfgov_search module settings
*/
class SfGovSearchConfigurationForm extends ConfigFormBase {

  const FUNNELBACK_COLLECTIONS = [
    'sfgov-meta-prod',
    'sfgov-meta-dev',
    'sf-dev-crawl',
    'sfgov-web-prod',
  ];

  const SETTINGS = 'sfgov_search.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sfgov_search_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      self::SETTINGS,
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(self::SETTINGS);
    $form['#prefix'] = $this->t('This form allows you to use a specific 311 Funnelback search collection.');
    $options = [];
    $arr = self::FUNNELBACK_COLLECTIONS;
    $count = count($arr);
    for($i=0; $i<$count; $i++) {
      $options[$arr[$i]] = $arr[$i];
    }
    $form['search_collection_name'] = [
      '#type' => 'select',
      '#title' => $this->t('Funnelback collection name'),
      '#options' => $options,
      '#default_value' => $config->get('search_collection'),
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config(self::SETTINGS)
      ->set('search_collection', $form_state->getValue('search_collection_name'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}