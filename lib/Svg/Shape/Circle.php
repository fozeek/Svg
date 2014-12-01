<?php 

namespace Svg\Shape;

use Svg\Shape\Shape;
use Svg\Shape\Point;
use Svg\Style;

class Circle extends Shape {

    protected $center;      // Point
    protected $rayon;       // Integer

    public function __construct(Point $center, $rayon, Style $style = null) {
        $this->center = $center;
        $this->rayon = $rayon;
        if($style !== null) {
            parent::setStyle($style);
        }
        return $this;
    }

    public function display() {
        return '<circle cx="'.$this->center->getX().'" cy="'.$this->center->getY().'" r="'.$this->rayon.'" style="'.parent::getStyle()->getString().'" class="'.parent::getClass().'"/>';
    }

    public function setCenter(Point $center) {
        $this->center = $center;
        return $this;
    }

    public function getCenter() {
        return $this->center;
    }

    public function setRayon($rayon) {
        $this->rayon = $rayon;
        return $this;
    }

    public function getRayon() {
        return $this->rayon;
    }

}