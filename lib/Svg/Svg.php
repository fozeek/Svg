<?php

namespace Svg;

use Svg\Shape\Shape;

class Svg {

    protected $width;
    protected $height;
    protected $viewBox;
    protected $shapes = array();
    protected $style;
    protected $class;

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
        $this->style = new Style();
    }

    public function add(Shape $shape) {
        $this->shapes[] = $shape;
    }

    public function display($inline = false) {
        echo '<svg width="'.$this->width.'" height="'.$this->height.'" style="' . $this->getStyle()->getString() . '" class="' . $this->getClass() . '">';
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

    public function getStyle() {
        if(!empty($this->style)) {
            return $this->style;
        }
        $this->setStyle(new Style());
        return $this->getStyle();
    }

    public function setStyle(Style $style) {
        $this->style = $style;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

}