<?php

namespace Svg\Shape;

use Svg\Style;

class CakePart extends Shape
{

    protected $anchor;
    protected $radius;
    protected $begin;
    protected $end;
    protected $direction;
    protected $start;

    public function __construct($anchor, $radius, $begin, $end, $direction = 'right', $start = 'top'){
        $this->anchor = $anchor;
        $this->radius = $radius;
        $this->begin = $begin;
        $this->end = $end - 1;
        $this->direction = $direction;
        $this->start = $start;
    }

    public function display() 
    {
        $orientation = '0';
        $way = '0';
        if($this->end-$this->begin > 100) {
            $orientation = '1';
        }

        $beginRad = (pi() * $this->begin) / 100;
        $rad = (pi() * $this->end) / 100;

        $beginY = $this->anchor->getY() - cos($beginRad) * $this->radius;
        $beginX = $this->anchor->getX() - sin($beginRad) * $this->radius;

        $y = cos($beginRad) * $this->radius -cos($rad) * $this->radius;
        $x = sin($beginRad) * $this->radius -sin($rad) * $this->radius;

        if($this->direction == 'right' && $this->start == 'top') {
            $beginY = $this->anchor->getY() - cos($beginRad) * $this->radius;
            $beginX = $this->anchor->getX() + sin($beginRad) * $this->radius;

            $y = cos($beginRad) * $this->radius - cos($rad) * $this->radius;
            $x = - sin($beginRad) * $this->radius + sin($rad) * $this->radius;
            $way = '1';
        }

        if($this->start == 'bottom' && $this->direction == 'left') {
            $beginY = $this->anchor->getY() + cos($beginRad) * $this->radius;
            $beginX = $this->anchor->getX() + sin($beginRad) * $this->radius;

            $y = -cos($beginRad) * $this->radius + cos($rad) * $this->radius;
            $x = -sin($beginRad) * $this->radius + sin($rad) * $this->radius;
        }

        if($this->direction == 'right' && $this->start == 'bottom') {
            $beginY = $this->anchor->getY() + cos($beginRad) * $this->radius;
            $beginX = $this->anchor->getX() - sin($beginRad) * $this->radius;

            $y = - cos($beginRad) * $this->radius + cos($rad) * $this->radius;
            $x = sin($beginRad) * $this->radius - sin($rad) * $this->radius;
            $way = '1';
        }

        //echo '<path d="M' . $this->anchor->getX() . ',' . $this->anchor->getY() . ' L' . $beginX . ',' . $beginY . ' a' . $this->radius . ',' . $this->radius . ' 0 ' . $orientation . ',0 ' . $x . ',' . $y . ' z" class="' . parent::getClass() . '" style="' . parent::getStyle() . '" />';
        return '<path d="M' . $beginX . ',' . $beginY . ' a' . $this->radius . ',' . $this->radius . ' 0 ' . $orientation . ',' . $way . ' ' . $x . ',' . $y . '" class="' . parent::getClass() . '" style="' . parent::getStyle()->getString() . '" />';
    
    }
}