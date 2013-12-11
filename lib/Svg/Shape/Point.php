<?php

namespace Svg\Shape;

use Svg\Shape\Shape;

class Point extends Shape {

    protected $x;
    protected $y;

    public function __construct($x, $y = null) {
        $this->setCoordonnees($x, $y);
    }

    public function getCoordonnees() {
        return array($this->x, $this->y);
    }

    public function setCoordonnees($x, $y = null) {
        if(is_array($x)) {
            $this->x = $x[0];
            $this->y = $x[1];
            return true;
        }
        $this->x = $x;
        $this->y = $y;
    }

    public function getX() {
        return $this->x;
    }

    public function setX($x) {
        $this->x = $x;
        return $this;
    }

    public function getY() {
        return $this->y;
    }

    public function setY($y) {
        $this->y = $y;
        return $this;
    }

}