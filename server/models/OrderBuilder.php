<?php

namespace SSPickup\models;

class OrderBuilder {
	protected $_data;

	protected $_order;

	public function __construct($data, $location_id)
	{
		$this->_data = $data;
		$this->_order = [
			'location_id' => $location_id
		];
	}

	public function getOrder()
	{
		$this->_buildOrder();
		return $this->_order;
	}

	protected function _buildOrder()
	{
		$this->_buildOrderItems();
		$this->_buildFulfillments();
		$this->_buildOrderTotals();
	}

	protected function _buildOrderItems()
	{
		foreach ($this->_data->items as $item) {
			$orderItem = new OrderItem($item);
			$this->_order['line_items'][] = $orderItem->getItem();
		}
	}

	protected function _buildFulfillments()
	{

		$pickupTime = date_create_from_format(
			'm/d/Y g:i A',
			date('m/d/Y') . ' ' . $this->_data->order->time
		);

		$this->_order['fulfillments'][0] = [
			'pickup_details' => [
				'pickup_at' => $pickupTime->format(DATE_RFC3339),
				'recipient' => [
					'display_name' => $this->_data->order->name,
					'email_address' => $this->_data->order->email
				],
			],
			'type' => 'PICKUP'
		];

		if ($this->_data->order->curbside) {
			$this->_order['fulfillments'][0]['note'] = 'The customer has requested curbside delivery';
		}
	}

	protected function _buildOrderTotals()
	{
		$this->_order['taxes']= [
			[
				'name' => 'Sales Tax',
				'type' => 'ADDITIVE',
				'scope' => 'ORDER',
				'percentage' => (string)($this->_data->order->location->taxRate * 100)
			]
		];

		if ($this->_data->totals->tip > 0) {
			$this->_order['service_charges'] = [
				[
					'name' => 'Tip',
					'amount_money' => [
						'amount' => (int) ($this->_data->totals->tip * 100),
						'currency' => 'USD',
					],
					'taxable' => false,
					'calculation_phase' => 'TOTAL_PHASE'
				]
			];
		}

	}

}