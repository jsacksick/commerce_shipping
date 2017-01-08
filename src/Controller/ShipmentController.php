<?php

namespace Drupal\commerce_shipping\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides the settings page.
 */
class ShipmentController extends ControllerBase {

  /**
   * Provides the settings page.
   */
  public function settingsPage() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Shipment settings'),
    ];
  }

}
