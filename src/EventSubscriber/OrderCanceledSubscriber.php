<?php

namespace Drupal\commerce_shipping\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Cancel the shipment when an order is canceled.
 */
class OrderCanceledSubscriber implements EventSubscriberInterface {

  /**
   * The shipment entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $shipmentStorage;

  /**
   * The entity query for shipments.
   *
   * @var \Drupal\Core\Entity\Query\QueryInterface
   */
  protected $entityQuery;

  /**
   * Constructs a new OrderCanceledSubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The entity query factory.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, QueryFactory $query_factory) {
    $this->shipmentStorage = $entity_type_manager->getStorage('commerce_shipment');
    $this->entityQuery = $query_factory->get('commerce_shipment');
  }

  /**
   * Cancel the shipments that reference this order.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The event we subscribed to.
   */
  public function cancelShipment(WorkflowTransitionEvent $event) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();
    $query = $this->entityQuery->condition('order_id', $order->id());
    $results = $query->execute();

    if (!empty($results)) {
      $shipments = $this->shipmentStorage->loadMultiple($results);

      foreach ($shipments as $shipment) {
        $shipment->state = 'canceled';
        $shipment->save();
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = ['commerce_order.cancel.post_transition' => ['cancelShipment', -100]];
    return $events;
  }

}
