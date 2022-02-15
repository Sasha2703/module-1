<?php

namespace Drupal\sasha_cat\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class CatForm extends FormBase {


  public function getFormId() {
    return 'sasha_cat_settings';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['adding_cat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your cat’s name:'),
      '#placeholder' => $this->t('The name must be in range from 2 to 32 symbols'),
    ];
    $form ['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add cat'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

//  public function validateForm(array &$form, FormStateInterface $form_state) {
//    if ($form_state->getValue('example') != 'example') {
//      $form_state->setErrorByName('example', $this->t('The value is not correct.'));
//    }
//    parent::validateForm($form, $form_state);
//  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addStatus(t('Congratulations! You added your cat!;)'));
  }

}
