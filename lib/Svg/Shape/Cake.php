<?php

namespace Svg\Shape;

use Svg\Style;

class Cake extends Shape
{

    protected $anchor;
    protected $radius;
    protected $parts;
    protected $percents;

    public function __construct($anchor, $radius, $percents, $options = array()){
        $this->anchor = $anchor;
        $this->radius = $radius;
        $this->percents = $percents;
        $this->options = $options;
    }

    public function display() 
    {
        for($cpt = 0;$cpt<count($this->percents)-1;$cpt++) {
            $cakepart = Shape::CakePart($this->anchor, $this->radius, $this->percents[$cpt], $this->percents[$cpt+1]);
            if(is_array($this->options['class']) && isset($this->options['class'][$cpt])) {
                $cakepart->setClass($this->options['class'][$cpt]);
            } elseif (isset($this->options['class'])) {
                $cakepart->setClass(str_replace(':cpt', $cpt, $this->options['class']));
            }
            $cakepart->display();
        }
    }
}