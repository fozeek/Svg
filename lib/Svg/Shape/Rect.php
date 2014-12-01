<?php 

namespace Svg\Shape;

use Svg\Shape\Shape;
use Svg\Shape\Point;
use Svg\Style;

class Rect extends Shape {

    protected $anchor;
    protected $width;
    protected $height;

    public function __construct(Point $anchor, $width, $height, Style $style = null) {
        $this->anchor = $anchor;
        $this->width = $width;
        $this->height = $height;
        if($style !== null) {
            parent::setStyle($style);
        }
        return $this;
    }

    public function display() {
        return '<rect x="'.$this->anchor->getX().'" y="'.$this->anchor->getY().'" width="'.$this->width.'" height="'.$this->height.'" style="'.parent::getStyle()->getString().'"  class="'.parent::getClass().'"/>';
    }

    public function getAnchor() {
        return $this->anchor;
    }

    public function setAnchor(Point $anchor) {
        $this->anchor = $anchor;
        return $this;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }
    
}