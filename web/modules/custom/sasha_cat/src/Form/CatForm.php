<?php

namespace Drupal\sasha_cat\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;

class CatForm extends FormBase
{


  public function getFormId()
  {
    return 'sasha_cat';
  }


  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['adding_cat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your cat’s name:'),
      '#placeholder' => $this->t('The name must be in range from 2 to 32 symbols'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your email:'),
      '#placeholder' => $this->t('example@email.com'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::AjaxEmail',
        'event' => 'change',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];
    $form ['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add cat'),
      '#button_type' => 'primary',
      '#ajax' => [
        'callback' => '::AjaxSubmit',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if ((mb_strlen($form_state->getValue('adding_cat')) < 2)) {
      $form_state->setErrorByName('adding_cat', $this->t('Your cat`s name should be more than 2 symbols.'));
    }
    if ((mb_strlen($form_state->getValue('adding_cat')) > 32)) {
      $form_state->setErrorByName('adding_cat', $this->t('Your cat`s name should be less than 32 symbols.'));
    }
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {
//    \Drupal::messenger()->addStatus(t('Congratulations! You added your cat!;)'));
  }

  public function AjaxSubmit(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    if ($form_state->hasAnyErrors()) {
      foreach ($form_state->getErrors() as $errors_array) {
        $response->addCommand(new MessageCommand($errors_array, NULL, ['type' => 'error']));
      }
    } else {
      $response->addCommand(new MessageCommand('Congratulations! You added your cat!'));
    }
    \Drupal::messenger()->deleteAll();
    return $response;
  }
  public function AjaxEmail(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    if (preg_match("/^[a-zA-Z_\-]+@[a-zA-Z_\-\.]+\.[a-zA-Z\.]{2,6}+$/", $form_state->getValue('email'))){
      $response->addCommand(new MessageCommand('Your email is invalid'));
    } else {
      $response->addCommand(new MessageCommand('Your email is NOT invalid', ".null", ['type' => 'error'], ));
    }
    return $response;
  }
}
