<?php

namespace Drupal\commerce_shipping;

/**
 * Represents a shipment item.
 */
final class ShipmentItem {

  /**
   * The purchased entity type.
   *
   * @var string
   */
  protected $purchasedEntityType;

  /**
   * The purchased entity ID.
   *
   * @var string
   */
  protected $purchasedEntityId;

  /**
   * The quantity.
   *
   * @var float
   */
  protected $quantity;

  /**
   * Constructs a new ShipmentItem object.
   *
   * @param array $definition
   *   The definition.
   */
  public function __construct(array $definition) {
    foreach (['purchased_entity_type', 'purchased_entity_id', 'quantity'] as $required_property) {
      if (empty($definition[$required_property])) {
        throw new \InvalidArgumentException(sprintf('Missing required property %s.', $required_property));
      }
    }

    $this->purchasedEntityType = $definition['purchased_entity_type'];
    $this->purchasedEntityId = $definition['purchased_entity_id'];
    $this->quantity = $definition['quantity'];
  }

  /**
   * Gets the purchased entity type.
   *
   * @return string
   *   The purchased entity type.
   */
  public function getPurchasedEntityType() {
    return $this->purchasedEntityType;
  }

  /**
   * Gets the purchased entity ID.
   *
   * @return string
   *   The purchased entity ID.
   */
  public function getPurchasedEntityId() {
    return $this->purchasedEntityId;
  }

  /**
   * Gets the quantity.
   *
   * @return float
   *   The quantity.
   */
  public function getQuantity() {
    return $this->quantity;
  }

}
