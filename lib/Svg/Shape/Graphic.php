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
    protected $xSteps = array();
    protected $ySteps = array();
    protected $grid = array();


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

        $this->generateSteps($lenghX, $lenghY, $xMax, $xMin, $yMax, $yMin, $percent);

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

    private function generateSteps($lenghX, $lenghY, $xMax, $xMin, $yMax, $yMin, $percent) {
        $echelleUnits = $this->echelle[0];
        $units = 1;
        while($echelleUnits<50) {
            $echelleUnits += $this->echelle[0];
            $units ++;
        }
        for ($cpt = $units;$cpt <= $xMax;$cpt += $units) {
            $this->xSteps[] = Shape::text(new Point($this->getCoordonneeX($cpt, $percent), $this->origine->getY()+15), $cpt, new Style(array('textAnchor' => 'middle'))); 
        }
        for ($cpt = -$units;$cpt >= $xMin;$cpt -= $units) {
            $this->xSteps[] = Shape::text(new Point($this->getCoordonneeX($cpt, $percent), $this->origine->getY()+15), $cpt, new Style(array('textAnchor' => 'middle'))); 
        }

        $echelleUnits = $this->echelle[1];
        $units = 1;
        while($echelleUnits<50) {
            $echelleUnits += $this->echelle[1];
            $units ++;
        }

        for ($cpt = $units;$cpt <= $yMax;$cpt += $units) {
            $this->ySteps[] = Shape::text(new Point($this->origine->getX()+10, $this->getCoordonneeY($cpt, $percent)), $cpt, new Style(array('textAnchor' => 'right', 'baselineShift' => '-0.5ex'))); 
        }
        for ($cpt = -$units;$cpt >= $yMin;$cpt -= $units) {
            $this->ySteps[] = Shape::text(new Point($this->origine->getX()+10, $this->getCoordonneeY($cpt, $percent)), $cpt, new Style(array('textAnchor' => 'right', 'baselineShift' => '-0.5ex'))); 
        }

        $this->generateGrid($xMax, $xMin, $yMax, $yMin, $percent);
    }

    private function generateGrid($xMax, $xMin, $yMax, $yMin, $percent) {

        foreach ($this->xSteps as $step) {
            $line = Shape::path()
                ->addPoint('M', new Point($step->getAnchor()->getX(), $this->getCoordonneeY($yMax, $percent)))
                ->addPoint('L', new Point($step->getAnchor()->getX(), $this->getCoordonneeY($yMin, $percent)));
            $line->getStyle()->setStroke('#ccc')->setStrokeWidth(1);
            $this->grid[] = $line;
        }

        foreach ($this->ySteps as $step) {
            $line = Shape::path()
                ->addPoint('M', new Point($this->getCoordonneeX($xMax, $percent), $step->getAnchor()->getY()))
                ->addPoint('L', new Point($this->getCoordonneeX($xMin, $percent), $step->getAnchor()->getY()));
            $line->getStyle()->setStroke('#ccc')->setStrokeWidth(1);
            $this->grid[] = $line;
        }

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
        foreach ($this->grid as $line) {
            $line->display();
        }
        $this->fullCurve->display();
        $this->abscisse->display();
        $this->ordonnee->display();
        $this->pathCurve->display();
        foreach ($this->anchors as $anchor) {
            $anchor->display();
        }
        foreach ($this->xSteps as $step) {
            $step->display();
        }
        foreach ($this->ySteps as $step) {
            $step->display();
        }
    }

}
