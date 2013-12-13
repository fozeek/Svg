<?php

namespace Svg\Shape;

use Svg\Style;

class Graphic extends Shape {

    protected $graphic; 
    protected $origine;
    protected $echelle = array(50, 1);
    protected $abscisse;
    protected $ordonnee;
    protected $maxAbcisse;
    protected $maxOrdonnee;
    protected $reperesAbcisse = array();
    protected $reperesOrdonnees = array();
    protected $anchors = array();
    protected $fullCurve;
    protected $pathCurve;
    protected $datas = array();
    protected $steps;

    public function __construct(array $datas, Point $anchor, $width, $height, array $options = array()) {

        if(array_key_exists('percent', $options) && $options['percent']) {
            $percent = '%';
        }
        else {
            $percent = '';
        }

        $this->datas = $datas;
        $this->ksortDatas();
        $count = count($this->datas);

        if(array_key_exists('xMax', $options)) {
            $xMax = $options['xMax'];
        } else {
            $xMax = max(array_keys($this->datas));
        }
        if(array_key_exists('yMax', $options)) {
            $yMax = $options['yMax'];
        } else {
            $yMax = max(array_values($this->datas));
        }
        if(array_key_exists('xMin', $options)) {
            $xMin = $options['xMin'];
        } else {
            $xMin = min(array_keys($this->datas));
        }
        if(array_key_exists('yMin', $options)) {
            $yMin = $options['yMin'];
        } else {
            $yMin = min(array_values($this->datas));
        }

        $lenghX = abs($xMax)+abs($xMin);
        $lenghY = abs($yMax)+abs($yMin);

        $this->echelle = array(
            $width/$lenghX,
            $height/$lenghY,
        );

        $this->origine = new Point(($anchor->getX() + abs($xMin)*$this->echelle[0]), ($anchor->getX() + $yMax*$this->echelle[1]));
        $this->maxAbcisse = new Point((max(array_keys($this->datas))*$this->echelle[0]+$this->origine->getX()).$percent, ($this->origine->getY()).$percent);
        $this->maxOrdonnee = new Point(($this->origine->getX()).$percent, ($this->origine->getY() - (max(array_values($this->datas))*$this->echelle[1])).$percent);
        $this->minAbcisse = new Point((min(array_keys($this->datas))*$this->echelle[0]+$this->origine->getX()).$percent, ($this->origine->getY()).$percent);
        $this->minOrdonnee = new Point(($this->origine->getX()).$percent, ($this->origine->getY() - (min(array_values($this->datas))*$this->echelle[1])).$percent);
        $this->abscisse = Shape::line(
            new Point(($anchor->getX()).$percent, ($this->origine->getY()).$percent),
            new Point(($anchor->getX()+$width).$percent, ($this->origine->getY()).$percent)
        );
        $this->abscisse->getStyle()->setStroke('black')
                        ->setStrokeWidth('1');
        $this->ordonnee = Shape::line(
            new Point(($this->origine->getX()).$percent, ($anchor->getX()).$percent),
            new Point(($this->origine->getX()).$percent, ($anchor->getX() + $height).$percent)
        );
        $this->ordonnee->getStyle()->setStroke('black')
                        ->setStrokeWidth('1');

        $this->graphic = Shape::rect($anchor, $width.$percent, $height.$percent);
        $this->graphic->getStyle()->setFill('transparent');

        $this->fullCurve = Shape::path();
        $this->pathCurve = Shape::path();

        $this->fullCurve->addPoint('M', $this->minAbcisse);
        $cpt = 0;
        foreach ($this->datas as $key => $value) {
            $point = new Point($this->getCoordonnees($key, $value, (array_key_exists('percent', $options) && $options['percent'])));
            $shape = Shape::circle($point, 4);
            $shape->setClass('circle');
            $this->anchors[] = $shape;
            $this->fullCurve->addPoint('L', $point);
            $this->pathCurve->addPoint(($cpt==0) ? 'M': 'L', $point);
            $cpt++;
        }

        $this->steps = array();

        $moyenne = round($lenghX/5);
        $min = round($xMin/$moyenne);

        for ($cpt = $min;$cpt <= $xMax;$cpt = $cpt + $moyenne) {
            $this->steps[] = Shape::text(new Point($this->getCoordonneeX($cpt, $percent), $this->origine->getY()+15), $cpt, new Style(array('textAnchor' => 'middle'))); 
        }
        $moyenne = round($lenghY/5);
        $min = round($yMin/$moyenne);
        for ($cpt = $min;$cpt <= $yMax;$cpt = $cpt + $moyenne) {
            $this->steps[] = Shape::text(new Point($this->origine->getX()+5, $this->getCoordonneeY($cpt, $percent)), $cpt, new Style(array('textAnchor' => 'right', 'baselineShift' => '-0.5ex'))); 
        }

        $this->pathCurve->setClass('curve');
        $this->fullCurve->addPoint('L', $this->maxAbcisse);
        $this->fullCurve->addPoint('L', $this->origine);
        $this->fullCurve->getStyle()->setFill('#E5E5E5');

    }

    private function getCoordonnees($x, $y, $percent) {
        if($percent) {
            $percent = '%';
        } else {
            $percent = '';
        }
        return array(
            ($this->origine->getX() + ($x*$this->echelle[0])).$percent,
            ($this->origine->getY() - ($y*$this->echelle[1])).$percent
        );
    }

    private function getCoordonneeX($x, $percent) {
        if($percent) {
            $percent = '%';
        } else {
            $percent = '';
        }
        return ($this->origine->getX() + ($x*$this->echelle[0])).$percent;
    }

    private function getCoordonneeY($y, $percent) {
        if($percent) {
            $percent = '%';
        } else {
            $percent = '';
        }
        return ($this->origine->getY() - ($y*$this->echelle[1])).$percent;
    }

    public function ksortDatas() {
        ksort($this->datas);
        return $this;
    }

    public function display() {
        //$this->graphic->display();
        $this->fullCurve->display();
        $this->abscisse->display();
        $this->ordonnee->display();
        $this->pathCurve->display();
        foreach ($this->anchors as $anchor) {
            $anchor->display();
        }
        foreach ($this->steps as $step) {
            $step->display();
        }
    }

}
