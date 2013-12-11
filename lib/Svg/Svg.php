<?php

namespace Svg;

use Svg\Shape\Shape;

class Svg {

    protected $width;
    protected $height;
    protected $shapes = array();

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function add(Shape $shape) {
        $this->shapes[] = $shape;
    }

    public function display($inline = false) {
        echo '<svg width="'.$this->width.'" height="'.$this->height.'">';
        foreach ($this->shapes as $shape) {
            $shape->display();
        }
        echo '</svg>';
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

}