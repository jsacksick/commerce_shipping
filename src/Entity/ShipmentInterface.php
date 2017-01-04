<?php

namespace Drupal\commerce_shipping\Entity;

use Drupal\commerce_shipping\Plugin\Commerce\PackageType\PackageTypeInterface;
use Drupal\commerce_shipping\ShipmentItem;
use Drupal\commerce_order\EntityAdjustableInterface;
use Drupal\commerce_price\Price;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\profile\Entity\ProfileInterface;

/**
 * Defines the interface for shipments.
 *
 * @todo Complete the method list.
 */
interface ShipmentInterface extends ContentEntityInterface, EntityAdjustableInterface, EntityChangedInterface {

  /**
   * Gets the parent order.
   *
   * @return \Drupal\commerce_order\Entity\OrderInterface|null
   *   The order, or NULL if unknown.
   */
  public function getOrder();

  /**
   * Gets the parent order ID.
   *
   * @return int|null
   *   The order ID, or NULL if unknown.
   */
  public function getOrderId();

  /**
   * Gets the shipping method.
   *
   * @return \Drupal\commerce_shipping\Entity\ShippingMethodInterface|null
   *   The shipping method, or NULL if unknown.
   */
  public function getShippingMethod();

  /**
   * Sets the shipping method.
   *
   * @param \Drupal\commerce_shipping\Entity\ShippingMethodInterface $shipping_method
   *   The shipping method.
   *
   * @return $this
   */
  public function setShippingMethod(ShippingMethodInterface $shipping_method);

  /**
   * Gets the shipment shipping service.
   *
   * @return string|null
   *   The shipment shipping service, if available. NULL otherwise.
   */
  public function getShippingService();

  /**
   * Sets the shipment shipping service.
   *
   * @param string $shipping_service
   *   The shipment shipping service.
   *
   * @return $this
   */
  public function setShippingService($shipping_service);

  /**
   * Gets the shipping method ID.
   *
   * @return string|null
   *   The shipping method ID, or NULL if unknown.
   */
  public function getShippingMethodId();

  /**
   * Gets the shipping profile.
   *
   * @return \Drupal\profile\Entity\ProfileInterface
   *   The shipping profile.
   */
  public function getShippingProfile();

  /**
   * Sets the shipping profile.
   *
   * @param \Drupal\profile\Entity\ProfileInterface $profile
   *   The shipping profile.
   *
   * @return $this
   */
  public function setShippingProfile(ProfileInterface $profile);

  /**
   * Gets the shipment tracking code.
   *
   * Only available if shipping method supports tracking and the shipment
   * itself has been shipped.
   *
   * @return string|null
   *   The shipment tracking code, if available. NULL otherwise.
   */
  public function getTrackingCode();

  /**
   * Sets the shipment tracking code.
   *
   * @param string $tracking_code
   *   The shipment tracking code.
   *
   * @return $this
   */
  public function setTrackingCode($tracking_code);

  /**
   * Gets the shipment amount.
   *
   * @return \Drupal\commerce_price\Price|null
   *   The shipment amount, or NULL.
   */
  public function getAmount();

  /**
   * Sets the shipment amount.
   *
   * @param \Drupal\commerce_price\Price $amount
   *   The shipment amount.
   *
   * @return $this
   */
  public function setAmount(Price $amount);

  /**
   * Gets the shipment state.
   *
   * @return \Drupal\state_machine\Plugin\Field\FieldType\StateItemInterface
   *   The shipment state.
   */
  public function getState();

  /**
   * Gets the shipment weight.
   *
   * @return \Drupal\physical\Weight|null
   *   The shipment weight, or NULL if unknown.
   */
  public function getWeight();

  /**
   * Gets the package type.
   *
   * @return \Drupal\commerce_shipping\Plugin\Commerce\PackageType\PackageTypeInterface|null
   *   The shipment package type, if available. NULL otherwise.
   */
  public function getPackageType();

  /**
   * Sets the package type.
   *
   * @param \Drupal\commerce_shipping\Plugin\Commerce\PackageType\PackageTypeInterface
   *   The package type.
   *
   * @return $this
   */
  public function setPackageType(PackageTypeInterface $package_type);

  /**
   * Gets the shipment creation timestamp.
   *
   * @return int
   *   The shipment creation timestamp.
   */
  public function getCreatedTime();

  /**
   * Sets the shipment creation timestamp.
   *
   * @param int $timestamp
   *   The shipment creation timestamp.
   *
   * @return $this
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the shipment shipping timestamp.
   *
   * @return int
   *   The shipment shipping timestamp.
   */
  public function getShippedTime();

  /**
   * Sets the shipment shipping timestamp.
   *
   * @param int $timestamp
   *   The shipment shipping timestamp.
   *
   * @return $this
   */
  public function setShippedTime($timestamp);

  /**
   * Gets the shipment items.
   *
   * @return \Drupal\commerce_shipping\ShipmentItem[]
   *   The shipment items.
   */
  public function getItems();

  /**
   * Sets the shipment items.
   *
   * @param \Drupal\commerce_shipping\ShipmentItem[] $shipment_items
   *   The shipment items.
   *
   * @return $this
   */
  public function setItems(array $shipment_items);

  /**
   * Adds a shipment item.
   *
   * @param \Drupal\commerce_shipping\ShipmentItem $shipment_item
   *   The shipment item.
   *
   * @return $this
   */
  public function addItem(ShipmentItem $shipment_item);

  /**
   * Removes a shipment item.
   *
   * @param \Drupal\commerce_shipping\ShipmentItem $shipment_item
   *   The shipment item to remove.
   *
   * @return $this
   */
  public function removeItem(ShipmentItem $shipment_item);

}
