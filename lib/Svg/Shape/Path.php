<?php

namespace Svg\Shape;

use Svg\Style;
use Svg\Shape\Shape;

class Path extends Shape {
    
    protected $path = array();

    public function __construct(Style $style = null) {
        if($style !== null) {
            parent::setStyle($style);
        }
        return $this;
    }

    public function addPoint($link, Point $point = null, $options = array()) {
        $this->path[] = array(
            'link' => $link,
            'point' => $point,
            'options' => $options
        );
        return $this;
    }

    public function display() {
        $d = '';
        foreach ($this->path as $value) {
            $d .= $value['link'].'';
            if($value['point'] !== null) {
                $d .= $value['point']->getX().','.$value['point']->getY();
            }
        }
        echo '<path d="'.$d.'" style="'.parent::getStyle()->getString().'" class="'.parent::getClass().'"/>';
    }

}