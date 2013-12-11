<?php

namespace Svg\Shape;

use Svg\Shape\Shape;
use Svg\Shape\Rectangle;
use Svg\Shape\Point;
use Svg\Shape\Path;

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
	protected $datas = array();
	protected $fullCurve;
	protected $pathCurve;
	protected $datas;

	public function __construct($datas) {
		$this->datas = $datas;
	}

	private function getCoordonnees($x, $y) {
        return array(
        	$this->origine->getX() + ($x*$this->echelle[0]),
        	$this->origine->getY() - ($y*$this->echelle[1])
        );
    }

    public function orderDatas() {
    	$this->datas = ksort($this->datas);
    }

	public function display() {

		this->origine = new Point(400, 400);
		$this->maxAbcisse = new Point(max(array_keys($datas))*$this->echelle[0]+$this->origine->getX(), $this->origine->getY());
		$this->maxOrdonnee = new Point($this->origine->getX(), ($this->origine->getY() - (max(array_values($datas))*$this->echelle[1])));
		$this->minAbcisse = new Point(min(array_keys($datas))*$this->echelle[0]+$this->origine->getX(), $this->origine->getY());
		$this->minOrdonnee = new Point($this->origine->getX(), ($this->origine->getY() - (min(array_values($datas))*$this->echelle[1])));
		$this->abscisse = Shape::path()
			->addPoint('M', $this->minAbcisse)
			->addPoint('L', $this->maxAbcisse);
		$this->abscisse->getStyle()->setStroke('black')
						->setStrokeWidth('1');
		$this->ordonnee = Shape::path()
			->addPoint('M', $this->minOrdonnee)
			->addPoint('L', $this->maxOrdonnee);
		$this->ordonnee->getStyle()->setStroke('black')
						->setStrokeWidth('1');


		$this->graphic = Shape::rect(new Point($this->minAbcisse->getX(), $this->maxOrdonnee->getY()), max(array_keys($datas))*$this->echelle[0]+$this->origine->getX(), ($this->origine->getY() - (min(array_values($datas))*$this->echelle[1])));
		$this->graphic->getStyle()->setFill('transparent');

		$this->fullCurve = Shape::path();
		$this->pathCurve = Shape::path();

		$this->fullCurve->addPoint('M', $this->minAbcisse);
		$cpt = 0;
		foreach ($datas as $key => $value) {
			$point = new Point($this->getCoordonnees($key, $value));
			$shape = Shape::circle($point, 4);
			$shape->setClass('circle');
			$this->datas[] = $shape;
			$this->fullCurve->addPoint('L', $point);
			$this->pathCurve->addPoint(($cpt==0) ? 'M': 'L', $point);
			$cpt++;
		}

		$this->pathCurve->setClass('curve');
		$this->fullCurve->addPoint('L', $this->maxAbcisse);
		$this->fullCurve->addPoint('L', $this->origine);
		$this->fullCurve->getStyle()->setFill('E5E5E5');



		$this->graphic->display();
		$this->fullCurve->display();
		$this->abscisse->display();
		$this->ordonnee->display();
		$this->pathCurve->display();
		foreach ($this->datas as $data) {
			$data->display();
		}
	}

}

/*

            $echelleX = 1;
            $echelleY = 1;

            $origineX = 50;
            $origineY = 450;

            $abscisseX = 500;
            $abscisseY = 450;

            $ordonneesX = 50;
            $ordonneesY = 0;

            function getCoordonnees($x, $y, $origineX, $origineY, $echelleX, $echelleY) {
                $svgX = $origineX + ($x*$echelleX);
                $svgY = $origineY - ($y*$echelleY);
                return array($svgX, $svgY);
            }

            $origine = '50 450';
            $endAbscisse = '50 0';
            $endOrdonnees = '750 450';

            $x = 500;
            $y = 450;

            $data = array(
                0 => 400,
                50 => 420,
                100 => 380,
                150 => 350,
                200 => 200,
                250 => 250,
                300 => 420,
                350 => 250,
                400 => 386,
                450 => 346,
                500 => 50,
                550 => 150,
                600 => 250,
                650 => 250,
                700 => 250,
            );

            $maxX = max(array_keys($data));

            $path = 'M';
            $cpt = 0;
            foreach ($data as $key => $value) {
                $point = getCoordonnees($key, $value, $origineX, $origineY, $echelleX, $echelleY);
                if($cpt!=0) $path .' L';
                $path .= ' '.$point[0].' '.$point[1].' ';
                $cpt ++;
            }

        ?>
        <svg style="width:750px; height:500px;">
            <rect x="50" y="0" width="750" height="450" fill="#E5E5E5" />

            <?php for ($cpt = 50;$cpt<450; $cpt+=50) : ?>
                <path d="M 50 <?= $cpt ?> L 749 <?= $cpt ?>" style="stroke: #ccc;stroke-width: 1px;"/>
            <?php endfor ?>
            

            <path d="<?php echo $path ?> L <?= ($maxX+$origineX).' '.($origineY); ?> L <?= $origine; ?>" style="fill: #F9F9F9;"/>
            <path d="<?php echo $path ?>" style="fill: transparent;stroke: blue;stroke-width: 1px;"/>
            
            <path d="M <?= $origine ?> L <?= $endAbscisse ?>" style="stroke: #ccc;stroke-width: 2px;"/>
            <path d="M <?= $origine ?> L <?= $endOrdonnees ?>" style="stroke: #ccc;stroke-width: 2px;"/>

            <?php foreach ($data as $key => $value): $point = getCoordonnees($key, $value, $origineX, $origineY, $echelleX, $echelleY); ?>
                <circle cx="<?= $point[0] ?>" cy="<?= $point[1] ?>" r="5" class="circle"/>
            <?php endforeach ?>

            <?php for ($cpt = 50;$cpt<500; $cpt+=50) : ?>
                <text x="40" y="<?= $cpt ?>" style="text-anchor:end; baseline-shift:-0.5ex;"><?= 450-$cpt ?></text>
            <?php endfor ?>
        </svg>

  */