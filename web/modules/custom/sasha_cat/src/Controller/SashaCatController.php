<?php

namespace Drupal\sasha_cat\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for sasha-cat routes.
 */
class SashaCatController extends ControllerBase {

  /**
   * Builds the response.
   */
//  public function build() {
//
//    $build['content'] = [
//      '#type' => 'item',
//      '#markup' => $this->t('It works!====='),
//    ];
//
//    return $build;
//  }
  public function content() {
    $form = \Drupal::formBuilder()->getForm('Drupal\sasha_cat\Form\CatForm');
    return [
      '#theme' => 'sasha_cat',
      $form,
    ];

  }





}
