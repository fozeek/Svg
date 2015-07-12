<?php

namespace Svg\Shape;

use Svg\Style;

class Graphic extends Shape {

    protected $graphic; 
    protected $origine;
    protected $echelle = array(50, 1);
    protected $abscisse;
    protected $ordonnee;
    protected $maxAbscisse;
    protected $maxOrdonnee;
    protected $minAbscisse;
    protected $minOrdonnee;
    protected $reperesAbscisse = array();
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
            'path' => true,
            'gausse' => false,
            'barre' => false,
            'barre_height' => 40,
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
        if($this->xMax == 0) {
            $this->xMax = 10;
        }
        if($this->options->read('yMax')) {
            $this->yMax = $options['yMax'];
        } else {
            $this->yMax = max(array_values($this->datas));
        }
        if($this->yMax == 0) {
            $this->yMax = 10;
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

        
        $this->lenghX = $this->xMax - $this->xMin;
        $this->lenghY = $this->yMax - $this->yMin;

        $this->echelle = array(
            $this->options->read('width')/$this->lenghX,
            $this->options->read('height')/$this->lenghY,
        );

        $this->origine = new Point(($this->options->read('anchor')->getX() + (-$this->xMin)*$this->echelle[0]), ($this->options->read('anchor')->getY() + $this->lenghY*$this->echelle[1] + $this->yMin*$this->echelle[1]));

        
        if($this->yMin > 0) {
            $this->abscisseY = $this->getCoordonneeY($this->yMin);
        }
        elseif($this->yMax < 0){
            $this->abscisseY = $this->getCoordonneeY($this->yMax);
        }
        else {
            $this->abscisseY = $this->origine->getY();
        }

        if($this->xMin > 0) {
            $this->ordonneX = $this->getCoordonneeX($this->xMin);
        }
        elseif($this->xMax < 0){
            $this->ordonneX = $this->getCoordonneeX($this->xMax);
        }
        else {
            $this->ordonneX = $this->origine->getX();
        }

        $this->maxAbscisse = new Point($this->getCoordonneeX($this->xMax), $this->abscisseY);
        $this->minAbscisse = new Point($this->getCoordonneeX($this->xMin), $this->abscisseY);
        $this->maxOrdonnee = new Point($this->ordonneX, $this->getCoordonneeY($this->yMax));
        $this->minOrdonnee = new Point($this->ordonneX, $this->getCoordonneeY($this->yMin));

        $this->abscisse = Shape::line(
            // new Point(($this->options->read('anchor')->getX()).$this->percent, ($this->origine->getY()).$this->percent),
            // new Point(($this->options->read('anchor')->getX()+$this->options->read('width')).$this->percent, ($this->origine->getY()).$this->percent)
            $this->minAbscisse,
            $this->maxAbscisse
        );
        $this->abscisse->setClass('line');
        $this->ordonnee = Shape::line(
            // new Point(($this->origine->getX()).$this->percent, ($this->options->read('anchor')->getY()).$this->percent),
            // new Point(($this->origine->getX()).$this->percent, ($this->options->read('anchor')->getY() + $this->options->read('height')).$this->percent)
            $this->minOrdonnee,
            $this->maxOrdonnee
        );
        $this->ordonnee->setClass('line');

        $this->graphic = Shape::rect($this->options->read('anchor'), $this->options->read('width').$this->percent, $this->options->read('height').$this->percent);
        $this->graphic->setClass('rect');

        $this->fullCurve = Shape::path();
        $this->pathCurve = Shape::path();

        $this->fullCurve->addPoint('M', $this->minAbscisse);
        $cpt = 0;
        $lastPoint;
        foreach ($this->datas as $key => $value) {
            $point = new Point($this->getCoordonnees($key, $value));
            

            if($this->options->read('barre')) {
                $pointRect = new Point($point->getX()-($this->options->read('barre_height')/2), $point->getY());
                $height = $value*$this->echelle[1];
                if($height<0) {
                    $height = -$height;
                    $pointRect->setY($this->getCoordonneeY(0));
                }
                $shape = Shape::rect($pointRect, $this->options->read('barre_height'), $height);
                $shape->setClass('barre');
            } else {
                $shape = Shape::circle($point, 4);
                $shape->setClass('circle');
            }

            $this->anchors[] = $shape;
            $this->fullCurve->addPoint('L', $point);

            $options = array();
            if($this->options->read('gausse')) {
                // Calcul du q (Bézier curves)
                $q = array();
                $keyNext = $key+1;
                if(array_key_exists((string)$keyNext, $this->datas)) {
                    $nextCoordonnees = $this->getCoordonnees($keyNext, $this->datas[$keyNext]);
                    $q[0] = ($nextCoordonnees[0] - $point->getX())/2+20; // Point de distorsion
                    $q[1] = ($nextCoordonnees[1] - $point->getY())/2-50; // Point de distorsion
                    $q[2] = $nextCoordonnees[0] - $point->getX(); // Déplacement en X
                    $q[3] = $nextCoordonnees[1] - $point->getY(); // Déplacement en Y
                    //debug
                    $shape = Shape::circle(new Point(
                        $point->getX() + ($nextCoordonnees[0] - $point->getX())/2,
                        $point->getY() + ($nextCoordonnees[1] - $point->getY())/2
                    ), 4);
                    $shape->setClass('circle-red');
                    $this->anchors[] = $shape;
                }
                $options['q'] = implode(' ', $q);
            }

            $this->pathCurve->addPoint(($cpt==0) ? 'M': 'L', $point, $options);
            $cpt++;
        }

        $this->generateSteps();

        $this->pathCurve->setClass('path-curve');
        $this->fullCurve->addPoint('L', $this->maxAbscisse);
        $this->fullCurve->addPoint('Z');
        $this->fullCurve->setClass('full-curve');

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
            if($cpt > $this->xMin) {
                $shape = Shape::text(new Point($this->getCoordonneeX($cpt), $this->abscisseY+15), $cpt, new Style(array('textAnchor' => 'middle')));
                $this->xSteps[] = $shape->setClass('dot');
            }
        }
        for ($cpt = -$units;$cpt >= $this->xMin;$cpt -= $units) {
            if($cpt < $this->xMax) {
                $shape = Shape::text(new Point($this->getCoordonneeX($cpt), $this->abscisseY+15), $cpt, new Style(array('textAnchor' => 'middle')));
                $this->xSteps[] = $shape->setClass('dot');
            }
        }

        $echelleUnits = $this->echelle[1];
        $units = 1;
        while($echelleUnits<$this->options->read('steps.minYGap')) {
            $echelleUnits += $this->echelle[1];
            $units ++;
        }

        for ($cpt = $units;$cpt <= $this->yMax;$cpt += $units) {
            if($cpt > $this->yMin) {
                $shape = Shape::text(new Point($this->ordonneX-10, $this->getCoordonneeY($cpt)), $cpt, new Style(array('textAnchor' => 'end', 'baselineShift' => '-0.5ex')));
                $this->ySteps[] = $shape->setClass('dot');
            }
        }
        for ($cpt = -$units;$cpt >= $this->yMin;$cpt -= $units) {
            if($cpt < $this->yMax) {
                $shape = Shape::text(new Point($this->ordonneX+10, $this->getCoordonneeY($cpt)), $cpt, new Style(array('textAnchor' => 'middle', 'baselineShift' => '-0.5ex')));
                $this->ySteps[] = $shape->setClass('dot');
            }
        }

        $this->generateGrid();
    }

    private function generateGrid() {

        foreach ($this->xSteps as $step) {
            $line = Shape::path()
                ->addPoint('M', new Point($step->getAnchor()->getX(), $this->getCoordonneeY($this->yMax)))
                ->addPoint('L', new Point($step->getAnchor()->getX(), $this->getCoordonneeY($this->yMin)));
            $line->setClass('line');
            $this->grid[] = $line;
        }

        foreach ($this->ySteps as $step) {
            $line = Shape::path()
                ->addPoint('M', new Point($this->getCoordonneeX($this->xMax), $step->getAnchor()->getY()))
                ->addPoint('L', new Point($this->getCoordonneeX($this->xMin), $step->getAnchor()->getY()));
            $line->setClass('line');
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
        $string = '';
        $string .= $this->graphic->display();
        foreach ($this->grid as $line) {
            $string .= $line->display();
        }

        //shape::circle($this->origine, 10)->setClass('circle')->display();

        $string .= $this->fullCurve->display();
        $string .= $this->abscisse->display();
        $string .= $this->ordonnee->display();
        if($this->options->read('path')) {
            $string .= $this->pathCurve->display();
        }
        foreach ($this->anchors as $anchor) {
            $string .= $anchor->display();
        }
        foreach ($this->xSteps as $step) {
            $string .= $step->display();
        }
        foreach ($this->ySteps as $step) {
            $string .= $step->display();
        }
        return $string;
    }

}
