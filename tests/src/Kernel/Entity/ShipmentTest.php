<?php

namespace Drupal\Tests\commerce_shipping\Kernel\Entity;

use Drupal\commerce_price\Price;
use Drupal\commerce_order\Adjustment;
use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_shipping\Entity\Shipment;
use Drupal\commerce_shipping\Entity\ShippingMethod;
use Drupal\commerce_shipping\ShipmentItem;
use Drupal\physical\Weight;
use Drupal\profile\Entity\Profile;
use Drupal\Tests\commerce\Kernel\CommerceKernelTestBase;

/**
 * Tests the Shipment entity.
 *
 * @coversDefaultClass \Drupal\commerce_shipping\Entity\Shipment
 *
 * @group commerce_shipping
 */
class ShipmentTest extends CommerceKernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'entity_reference_revisions',
    'physical',
    'profile',
    'state_machine',
    'commerce_order',
    'commerce_product',
    'commerce_shipping',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installEntitySchema('profile');
    $this->installEntitySchema('commerce_order');
    $this->installEntitySchema('commerce_shipping_method');
    $this->installEntitySchema('commerce_shipment');
    $this->installConfig([
      'physical',
      'profile',
      'commerce_order',
      'commerce_shipping',
    ]);
  }

  /**
   * @covers ::getOrder
   * @covers ::getOrderId
   * @covers ::getPackageType
   * @covers ::setPackageType
   * @covers ::getShippingMethod
   * @covers ::getShippingMethodId
   * @covers ::setShippingMethod
   * @covers ::getShippingService
   * @covers ::setShippingService
   * @covers ::getShippingProfile
   * @covers ::setShippingProfile
   * @covers ::getItems
   * @covers ::setItems
   * @covers ::addItem
   * @covers ::removeItem
   * @covers ::getWeight
   * @covers ::setWeight
   * @covers ::getAmount
   * @covers ::setAmount
   * @covers ::getAdjustments
   * @covers ::setAdjustments
   * @covers ::addAdjustment
   * @covers ::removeAdjustment
   * @covers ::getTrackingCode
   * @covers ::setTrackingCode
   * @covers ::getState
   * @covers ::getCreatedTime
   * @covers ::setCreatedTime
   * @covers ::getShippedTime
   * @covers ::setShippedTime
   */
  public function testShipment() {
    $user = $this->createUser(['mail' => $this->randomString() . '@example.com']);
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = Order::create([
      'type' => 'default',
      'state' => 'draft',
      'mail' => $user->getEmail(),
      'uid' => $user->id(),
      'store_id' => $this->store->id(),
    ]);
    $order->save();
    $order = $this->reloadEntity($order);

    /** @var \Drupal\commerce_shipping\Entity\ShippingMethodInterface $shipping_method */
    $shipping_method = ShippingMethod::create([
      'name' => $this->randomString(),
      'status' => 1,
    ]);
    $shipping_method->save();
    $shipping_method = $this->reloadEntity($shipping_method);

    /** @var \Drupal\profile\Entity\ProfileInterface $profile */
    $profile = Profile::create([
      'type' => 'customer',
    ]);
    $profile->save();
    $profile = $this->reloadEntity($profile);

    $shipment = Shipment::create([
      'state' => 'ready',
      'order_id' => $order->id(),
    ]);

    $this->assertEquals($order, $shipment->getOrder());
    $this->assertEquals($order->id(), $shipment->getOrderId());

    $package_type_manager = \Drupal::service('plugin.manager.commerce_package_type');
    $package_type = $package_type_manager->createInstance('custom_box');
    $shipment->setPackageType($package_type);
    $this->assertEquals($package_type, $shipment->getPackageType());

    $shipment->setShippingMethod($shipping_method);
    $this->assertEquals($shipping_method, $shipment->getShippingMethod());
    $this->assertEquals($shipping_method->id(), $shipment->getShippingMethodId());

    $shipping_service = $this->randomString();
    $shipment->setShippingService($shipping_service);
    $this->assertEquals($shipping_service, $shipment->getShippingService());

    $shipment->setShippingProfile($profile);
    $this->assertEquals($profile, $shipment->getShippingProfile());

    $weight = new Weight('4', 'kg');
    $shipment->setWeight($weight);
    $this->assertEquals($weight, $shipment->getWeight());

    $amount = new Price('-1.00', 'USD');
    $shipment->setAmount($amount);
    $this->assertEquals($amount, $shipment->getAmount());

    $items = [];
    $items[] = new ShipmentItem([
      'purchased_entity_id' => 1,
      'purchased_entity_type' => 'commerce_product_variation',
      'quantity' => 2,
    ]);
    $items[] = new ShipmentItem([
      'purchased_entity_id' => 2,
      'purchased_entity_type' => 'commerce_product_variation',
      'quantity' => 2,
    ]);
    $shipment->addItem($items[0]);
    $shipment->addItem($items[1]);
    $this->assertEquals($items, $shipment->getItems());
    $shipment->removeItem($items[0]);
    $this->assertEquals([$items[1]], $shipment->getItems());
    $shipment->setItems($items);
    $this->assertEquals($items, $shipment->getItems());

    $adjustments = [];
    $adjustments[] = new Adjustment([
      'type' => 'custom',
      'label' => '10% off',
      'amount' => new Price('-1.00', 'USD'),
    ]);
    $adjustments[] = new Adjustment([
      'type' => 'custom',
      'label' => 'Handling fee',
      'amount' => new Price('10.00', 'USD'),
    ]);
    $shipment->addAdjustment($adjustments[0]);
    $shipment->addAdjustment($adjustments[1]);
    $this->assertEquals($adjustments, $shipment->getAdjustments());
    $shipment->removeAdjustment($adjustments[0]);
    $this->assertEquals([$adjustments[1]], $shipment->getAdjustments());
    $shipment->setAdjustments($adjustments);
    $this->assertEquals($adjustments, $shipment->getAdjustments());

    $tracking_code = $this->randomString();
    $shipment->setTrackingCode($tracking_code);
    $this->assertEquals($tracking_code, $shipment->getTrackingCode());

    $this->assertEquals('ready', $shipment->getState()->value);

    $shipment->setCreatedTime(635879700);
    $this->assertEquals(635879700, $shipment->getCreatedTime());

    $shipment->setShippedTime(635879800);
    $this->assertEquals(635879800, $shipment->getShippedTime());
  }

}
