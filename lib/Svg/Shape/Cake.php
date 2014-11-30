<?php

namespace Svg\Shape;

use Svg\Style;

class Cake extends Shape
{

    protected $anchor;
    protected $radius;
    protected $end;

    public function __construct($anchor, $radius, $begin, $end){
        $this->anchor = $anchor;
        $this->radius = $radius;
        $this->begin = $begin;
        $this->end = $end;
    }

    public function display() 
    {
        $orientation = '0';
        if($this->end-$this->begin > 100) {
            $orientation = '1';
        }

        $beginRad = (pi() * $this->begin) / 100;

        $beginY = $this->anchor->getY() -cos($beginRad) * $this->radius;
        $beginX = $this->anchor->getX() -sin($beginRad) * $this->radius;

        $rad = (pi() * $this->end) / 100;
        $y = cos($beginRad) * $this->radius -cos($rad) * $this->radius;
        $x = sin($beginRad) * $this->radius -sin($rad) * $this->radius;

        //echo '<path d="M' . $this->anchor->getX() . ',' . $this->anchor->getY() . ' L' . $beginX . ',' . $beginY . ' a' . $this->radius . ',' . $this->radius . ' 0 ' . $orientation . ',0 ' . $x . ',' . $y . ' z" class="' . parent::getClass() . '" style="' . parent::getStyle() . '" />';
        echo '<path d="M' . $beginX . ',' . $beginY . ' a' . $this->radius . ',' . $this->radius . ' 0 ' . $orientation . ',0 ' . $x . ',' . $y . '" class="' . parent::getClass() . '" style="' . parent::getStyle()->getString() . '" />';
    
    }
}