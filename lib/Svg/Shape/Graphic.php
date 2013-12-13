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
    protected $minGapXStep = 50;
    protected $minGapYStep = 40;
    protected $lenghX;
    protected $lenghY;
    protected $xMax;
    protected $xMin;
    protected $yMax;
    protected $yMin;
    protected $defaultOptions;

    private function setDefaultOptions() {
        $this->defaultOptions = array(
            'anchor' => new Point(0, 0),
            'width' => 400,
            'height' => 400,
            'percent' => false,
            'grid' => true,
            'full_curve' => true,
            'steps' => array(
                'show' => true,
                'minXGap' => 50,
                'minYGap' => 50
            ),
            'style' => array(
                'points' => array('class' => 'point'),
                'path_curve' => array('class' => 'path-curve'),
                'full_curve' => array('class' => 'full-curve'),
            ),
        );
    }

    public function __construct(array $datas, array $options = array()) {

        $this->setDefaultOptions();

        $this->options = new \Utility\Storage\Storage($this->defaultOptions);
        $this->options->merge($options);

        if($this->options->read('percent')) {
            $this->percent = '%';
        }
        else {
            $this->percent = '';
        }

        $this->datas = $datas;
        $this->ksortDatas();
        $count = count($this->datas);

        if($this->options->read('xMax')) {
            $this->xMax = $options['xMax'];
        } else {
            $this->xMax = max(array_keys($this->datas));
        }
        if($this->options->read('yMax')) {
            $this->yMax = $options['yMax'];
        } else {
            $this->yMax = max(array_values($this->datas));
        }
        if($this->options->read('xMin')) {
            $this->xMin = $options['xMin'];
        } else {
            $this->xMin = min(array_keys($this->datas));
        }
        if($this->options->read('yMin')) {
            $this->yMin = $options['yMin'];
        } else {
            $this->yMin = min(array_values($this->datas));
        }

        $this->lenghX = abs($this->xMax)+abs($this->xMin);
        $this->lenghY = abs($this->yMax)+abs($this->yMin);

        $this->echelle = array(
            $this->options->read('width')/$this->lenghX,
            $this->options->read('height')/$this->lenghY,
        );

        $this->origine = new Point(($this->options->read('anchor')->getX() + abs($this->xMin)*$this->echelle[0]), ($this->options->read('anchor')->getX() + $this->yMax*$this->echelle[1]));
        $this->maxAbcisse = new Point((max(array_keys($this->datas))*$this->echelle[0]+$this->origine->getX()).$this->percent, ($this->origine->getY()).$this->percent);
        $this->maxOrdonnee = new Point(($this->origine->getX()).$this->percent, ($this->origine->getY() - (max(array_values($this->datas))*$this->echelle[1])).$this->percent);
        $this->minAbcisse = new Point((min(array_keys($this->datas))*$this->echelle[0]+$this->origine->getX()).$this->percent, ($this->origine->getY()).$this->percent);
        $this->minOrdonnee = new Point(($this->origine->getX()).$this->percent, ($this->origine->getY() - (min(array_values($this->datas))*$this->echelle[1])).$this->percent);
        $this->abscisse = Shape::line(
            new Point(($this->options->read('anchor')->getX()).$this->percent, ($this->origine->getY()).$this->percent),
            new Point(($this->options->read('anchor')->getX()+$this->options->read('width')).$this->percent, ($this->origine->getY()).$this->percent)
        );
        $this->abscisse->getStyle()->setStroke('black')
                        ->setStrokeWidth('1');
        $this->ordonnee = Shape::line(
            new Point(($this->origine->getX()).$this->percent, ($this->options->read('anchor')->getX()).$this->percent),
            new Point(($this->origine->getX()).$this->percent, ($this->options->read('anchor')->getX() + $this->options->read('height')).$this->percent)
        );
        $this->ordonnee->getStyle()->setStroke('black')
                        ->setStrokeWidth('1');

        $this->graphic = Shape::rect($this->options->read('anchor'), $this->options->read('width').$this->percent, $this->options->read('height').$this->percent);
        $this->graphic->getStyle()->setFill('transparent');

        $this->fullCurve = Shape::path();
        $this->pathCurve = Shape::path();

        $this->fullCurve->addPoint('M', $this->minAbcisse);
        $cpt = 0;
        foreach ($this->datas as $key => $value) {
            $point = new Point($this->getCoordonnees($key, $value));
            $shape = Shape::circle($point, 4);
            $shape->setClass('circle');
            $this->anchors[] = $shape;
            $this->fullCurve->addPoint('L', $point);
            $this->pathCurve->addPoint(($cpt==0) ? 'M': 'L', $point);
            $cpt++;
        }

        $this->generateSteps();

        $this->pathCurve->setClass('curve');
        $this->fullCurve->addPoint('L', $this->maxAbcisse);
        $this->fullCurve->addPoint('Z');
        $this->fullCurve->getStyle()->setFill('transparent');

    }

    private function getCoordonnees($x, $y) {
        return array(
            ($this->origine->getX() + ($x*$this->echelle[0])).$this->percent,
            ($this->origine->getY() - ($y*$this->echelle[1])).$this->percent
        );
    }

    private function generateSteps() {
        $echelleUnits = $this->echelle[0];
        $units = 1;
        while($echelleUnits<$this->options->read('steps.minXGap')) {
            $echelleUnits += $this->echelle[0];
            $units ++;
        }
        for ($cpt = $units;$cpt <= $this->xMax;$cpt += $units) {
            $this->xSteps[] = Shape::text(new Point($this->getCoordonneeX($cpt), $this->origine->getY()+15), $cpt, new Style(array('textAnchor' => 'middle'))); 
        }
        for ($cpt = -$units;$cpt >= $this->xMin;$cpt -= $units) {
            $this->xSteps[] = Shape::text(new Point($this->getCoordonneeX($cpt), $this->origine->getY()+15), $cpt, new Style(array('textAnchor' => 'middle'))); 
        }

        $echelleUnits = $this->echelle[1];
        $units = 1;
        while($echelleUnits<$this->options->read('steps.minYGap')) {
            $echelleUnits += $this->echelle[1];
            $units ++;
        }

        for ($cpt = $units;$cpt <= $this->yMax;$cpt += $units) {
            $this->ySteps[] = Shape::text(new Point($this->origine->getX()+10, $this->getCoordonneeY($cpt)), $cpt, new Style(array('textAnchor' => 'right', 'baselineShift' => '-0.5ex'))); 
        }
        for ($cpt = -$units;$cpt >= $this->yMin;$cpt -= $units) {
            $this->ySteps[] = Shape::text(new Point($this->origine->getX()+10, $this->getCoordonneeY($cpt)), $cpt, new Style(array('textAnchor' => 'right', 'baselineShift' => '-0.5ex'))); 
        }

        $this->generateGrid();
    }

    private function generateGrid() {

        foreach ($this->xSteps as $step) {
            $line = Shape::path()
                ->addPoint('M', new Point($step->getAnchor()->getX(), $this->getCoordonneeY($this->yMax)))
                ->addPoint('L', new Point($step->getAnchor()->getX(), $this->getCoordonneeY($this->yMin)));
            $line->getStyle()->setStroke('#ccc')->setStrokeWidth(1);
            $this->grid[] = $line;
        }

        foreach ($this->ySteps as $step) {
            $line = Shape::path()
                ->addPoint('M', new Point($this->getCoordonneeX($this->xMax), $step->getAnchor()->getY()))
                ->addPoint('L', new Point($this->getCoordonneeX($this->xMin), $step->getAnchor()->getY()));
            $line->getStyle()->setStroke('#ccc')->setStrokeWidth(1);
            $this->grid[] = $line;
        }

    }

    private function getCoordonneeX($x) {
        return ($this->origine->getX() + ($x*$this->echelle[0])).$this->percent;
    }

    private function getCoordonneeY($y) {
        return ($this->origine->getY() - ($y*$this->echelle[1])).$this->percent;
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
