<?php

namespace Drupal\sasha_cat\Controller;
use Drupal\file\Entity\File;
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
      '#list'=>$this->catTable(),
    ];

  }
  public function catTable(): array
  {
    $query= \Drupal::database();
    $result = $query->select('sasha_cat', 'sasha_cattb')
      ->fields('sasha_cattb', ['name', 'email', 'image', 'date'])
      ->orderBy('date', 'DESC')
      ->execute()->fetchAll();
    $data = [];
    foreach ($result as $row) {
      $file = File::load($row->image);
      $uri = $file->getFileUri();
      $photoCats = [
        '#theme' => 'image',
        '#uri' => $uri,
        '#alt' => 'cat',
        '#title' => 'cat',
        '#width' => 255,
      ];
      $data[] = [
        'name' => $row->name,
        'email' => $row->email,
        'image' => [
          'data' => $photoCats,
        ],
        'date' => $row->date,
      ];
    };
    return $data;
  }





}
