<?php

namespace Drupal\sfgov_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SearchForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sfgov_search_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $keyword = \Drupal::request()->query->get('keyword');
    $config = \Drupal::config('sfgov_search.settings');
    $form['#attributes'] = array(
      'class' => array(
        'sfgov-search-form',
        'sfgov-search-form-311',
      ),
      'role' => 'search',
    );

    $form['sfgov_search_input'] = array(
      '#title' => 'Search',
      '#type' => 'textfield',
      '#placeholder' => t('Search'),
      '#attributes' => array(
        'class' => array(
          'sf-gov-search-input-class',
        ),
        'title' => 'Enter the terms you wish to search for.',
      ),
      '#suffix' => '<div id="sfgov-search-autocomplete"></div>',
    );

    $form['#prefix'] = '<div class="mobile-btn"><i class="fa fa-times"></i></div><div class="sfgov-mobile-btn-close"></div>';
    $form['#attached']['library'][] = 'sfgov_search/search';
    $form['#attached']['drupalSettings']['sfgovSearch']['collection'] = $config->get('search_collection');

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $keyword = $form_state->getValues()['sfgov_search_input'];
    $form_state->setRedirect('sfgov_search.content', ['keyword' => $keyword]);
  }
}