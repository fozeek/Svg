<?php

namespace Svg\Shape;

use Svg\Style;

class Text extends Shape {

    protected $anchor;
    protected $text;

    public function __construct(Point $anchor, $text, Style $style = null) {
        $this->anchor = $anchor;
        $this->text = $text;
        if($style !== null) {
            parent::setStyle($style);
        }
    }

    public function display() {
        echo '<text x="'.$this->anchor->getX().'" y="'.$this->anchor->getY().'" style="'.parent::getStyle()->getString().'" class="'.parent::getClass().'">'.$this->text.'</text>';
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