<?php

namespace Svg\Shape;

use Svg\Shape;
use Svg\Shape\Point;

class Text extends Shape {

	protected $anchor;
	protected $text;

	public function __construct(Point $anchor, $text) {
		$this->anchor = $anchor;
		$this->text = $text;
	}

	public function getAnchor() {
		return $this->anchor;
	}

	public function setAnchor(Point $anchor) {
		$this->anchor;
		return $this;
	}

	public function getText() {
		return $this->text;
	}

	public function setText($text) {
		$this->text = $text;
		return $this;
	}


}