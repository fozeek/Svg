<?php

namespace Svg\Shape;

use Svg\Style;

class Line extends Shape {

	protected $point1;
	protected $point2;

	public function __construct(Point $point1, Point $point2, Style $style = null) {
		$this->point1 = $point1;
		$this->point2 = $point2;
		if($style !==null) {
			$this->setStyle($style); 
		}
	}

	public function display() {
		return '<line x1="'.$this->point1->getX().'" y1="'.$this->point1->getY().'" x2="'.$this->point2->getX().'" y2="'.$this->point2->getY().'" style="'.parent::getStyle()->getString().'" class="'.parent::getClass().'"/>';
	}

}