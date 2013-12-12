<?php

namespace Svg;

class Style {

    protected $fill;
    protected $stroke;
    protected $strokeWidth;
    protected $strokeLinejoin;          // mitter | round | bevel
    protected $textAnchor;
    protected $baselineShift;

    public function __construct(array $style = array()) {
        foreach ($style as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function create(array $style = array()) {
        return new Style($style);
    }

    public function getString() {
        $style = '';
        if(!empty($this->fill)) {
            $style .= 'fill:'.$this->fill.'; ';
        }
        if(!empty($this->stroke)) {
            $style .= 'stroke:'.$this->stroke.'; ';
        }
        if(!empty($this->strokeWidth)) {
            $style .= 'stroke-width:'.$this->strokeWidth.'; ';
        }
        if(!empty($this->textAnchor)) {
            $style .= 'text-anchor:'.$this->textAnchor.'; ';
        }
        if(!empty($this->baselineShift)) {
            $style .= 'baseline-shift:'.$this->baselineShift.'; ';
        }
        if(!empty($this->strokeLinejoin)) {
            $style .= 'stroke-linejoin:'.$this->strokeLinejoin.'; ';
        }
        return $style;
    }

    public function getFill() {
        return $this->fill;
    }

    public function setFill($fill) {
        $this->fill = $fill;
        return $this;
    }

    public function getStroke() {
        return $this->stroke;
    }

    public function setStroke($stroke) {
        $this->stroke = $stroke;
        return $this;
    }

    public function getStrokeWidth() {
        return $this->strokeWidth;
    }

    public function setStrokeWidth($strokeWidth) {
        $this->strokeWidth = $strokeWidth;
        return $this;
    }

    public function getStrokeLineJoin() {
        return $this->strokeLinejoin;
    }

    public function setStrokeLineJoin($strokeLinejoin) {
        $this->strokeLinejoin = $strokeLinejoin;
        return $this;
    }

    public function getTextAnchor() {
        return $this->textAnchor;
    }

    public function setTextAnchor($textAnchor) {
        $this->textAnchor = $textAnchor;
        return $this;
    }

    public function getBaselineShift() {
        return $this->baselineShift;
    }

    public function setBaselineShift($baselineShift) {
        $this->baselineShift = $baselineShift;
        return $this;
    }

}