<?php

namespace Drupal\commerce_shipping\Plugin\Field\FieldType;

use Drupal\commerce_shipping\ShipmentItem;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Represents a list of shipment item field values.
 */
interface ShipmentItemListInterface extends FieldItemListInterface {

  /**
   * Gets the shipment item value objects from the field list.
   *
   * @return \Drupal\commerce_shipping\ShipmentItem[]
   *   An array of shipment items value objects.
   */
  public function getShipmentItems();

  /**
   * Removes the matching shipment item value.
   *
   * @param \Drupal\commerce_shipping\ShipmentItem $shipment_item
   *   The shipment item.
   *
   * @return $this
   */
  public function removeShipmentItem(ShipmentItem $shipment_item);

}
