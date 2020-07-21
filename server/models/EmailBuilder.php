<?php

namespace SSPickup\models;

class EmailBuilder {

	protected $_data;

	protected $_sections = [];

	public function __construct($data) {
		$this->_data = $data;
	}

	public function getBody() {
		$this->_defineLayout();
		$content = $this->_buildContent();

		return $content;

	}

	protected function _defineLayout() {
		// intro
		$this->_sections[] = [
			"heading" => null,
			"lines" => [
				"<strong>Thank you for choosing SEOULSPICE!</strong><br>We are so excited to <strong>#FEEDYOURSEOUL</strong> with delicious Korean comfort food 💪 🇰🇷"
			]
		];

		$order = $this->_data->order;

		// contact information
		$this->_sections[] = [
			"heading" => "Contact Information",
			"lines" => [
				$this->_getLine("Name", $order->name),
				$this->_getLine("Email", $order->email),
			]
		];

		$pickup_lines = [
			$this->_getLine("Location", $order->location->description . ' (' . $order->location->address . ')'),
			$this->_getLine("Time", $order->time),
		];

		if ($order->curbside) {
			$pickup_lines[] = "<br><em>Please call " . $order->location->phone . ' upon arriving at the restaurant and we will bring your order out to you.</em>';
		}

		$this->_sections[] = [
			"heading" => "Pickup Information",
			"lines" => $pickup_lines
		];

		$items = $this->_data->items;
		// order information
		$order_lines = [];

		foreach ($items as $item) {
			$item_line = $item->qty . ' X ' . $item->name . ' [' . $item->price * $item->qty . ']';
			if ( $item->type === 'entree' ) {
				$item_line .= "<ul>\r\n";
				foreach ($item->options as $option) {
					$item_line .= '<li><strong>' . $option->cartLabel . ': </strong>';
					$choices = array_map(static function($choice) {
						return $choice->name;
					}, $option->choices);
					$item_line .= implode(', ', $choices);
					$item_line .= "</li>\r\n";
				}
				$item_line .= "</ul>\r\n";
			}
			$order_lines[] = $item_line;
		}

		$this->_sections[] = [
			"heading" => "Order Information",
			"lines" => $order_lines
		];

		// totals
		$totals = $this->_data->totals;
		$subtotal = ($totals->subtotal) ? "$" . number_format($totals->subtotal, 2) : null;
		$tax = ($totals->tax) ? "$" . number_format($totals->tax, 2) : null;
		$tip = ($totals->tip > 0) ? "$" . number_format($totals->tip, 2) : null;
		$total = ($totals->total) ? "$" . number_format($totals->total, 2) : null;

		$this->_sections[] = [
			"heading" => "Order Totals",
			"lines" => [
				$this->_getLine("Subtotal", $subtotal),
				$this->_getLine("Tax", $tax),
				$this->_getLine("Tip", $tip),
				$this->_getLine("Total", $total),
			]
		];
	}

	public function _buildContent() {
		$content = "";

		foreach ($this->_sections as $section) {
			$paragraph = "";
			$paragraphContent = "";

			if ($section['heading']) {
				$paragraph .= "<h2>" . $section['heading'] . "</h2>\r\n";
			}

			foreach ($section['lines'] as $line) {
				if ($line !== null) {
					$paragraphContent .= $line . "<br>";
				}
			}

			if ($paragraphContent) {
				$paragraph .= "<p>" . $paragraphContent . "</p>";
			}

			if ($paragraph) {
				$content .= $paragraph;
			}
		}

		return $content;
	}

	public function _getLine($label, $data) {
		if ($data) {
			return "<strong>" . $label . ":</strong> " . $data;
		}

		return null;
	}

}