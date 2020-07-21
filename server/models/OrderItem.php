<?php

namespace SSPickup\models;

class OrderItem {

	protected $_data;

	protected $_item;

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function getItem()
	{
		$this->_buildItem();
		return $this->_item;
	}

	protected function _buildItem()
	{
		$this->_item = [
			'quantity' => (string)$this->_data->qty,
			'base_price_money' => [
				'amount' => (int)($this->_data->price * 100),
				'currency' => 'USD'
			],
			'name' => $this->_data->name
		];

		if ($this->_data->type === 'entree') {
			$this->_buildModifiers();
		}
	}

	protected function _buildModifiers()
	{
		foreach ($this->_data->options as $modifier) {
			$this->_item['modifiers'][] = [
				'base_price_money' => [
					'amount' => (int) 0, // we already account for the option prices in the item price
					'currency' => 'USD'
				],
				'name' => $this->_getModifierName($modifier)
			];
		}
	}

	protected function _getModifierPrice($modifier)
	{
		return array_reduce($modifier->choices, static function($carry, $choice) {
			return $carry + $choice->price;
		}, 0);
	}

	protected function _getModifierName($modifier) {
		$choiceNames = array_map(static function($choice) {
			return $choice->name;
		}, $modifier->choices);

		return $modifier->cartLabel . ': ' . implode(', ', $choiceNames);
	}
}