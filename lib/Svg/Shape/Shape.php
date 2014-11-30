<?php

namespace Svg\Shape;

use Svg\Style;

abstract class Shape {

    protected $style;
    protected $class;

    static public function circle(Point $center, $rayon, Style $style = null) {
        return new Circle($center, $rayon, $style);
    }

    static public function rect(Point $anchor, $width, $height, Style $style = null) {
        return new Rect($anchor, $width, $height, $style);
    }

    static public function text(Point $anchor, $text, Style $style = null) {
        return new Text($anchor, $text, $style);
    }

    static public function path(Style $style = null) {
        return new Path($style);
    }

    static public function point($x, $y) {
        return new Point($x, $y);
    }

    static public function graphic(array $datas = array(), array $options = array()) {
        return new Graphic($datas, $options);
    }

    static public function line(Point $point1, Point $point2,  Style $style = null) {
        return new Line($point1, $point2, $style);
    }

    static public function Cake(Point $anchor, $radius, $begin, $end) {
        return new Cake($anchor, $radius, $begin, $end);
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