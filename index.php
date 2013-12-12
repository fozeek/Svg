<?php require 'autoloader.php' ?>
<!DOCTYPE>
    <head>
        <title>Svg</title>
        <style>
            .circle {
                transition-duration: 1s;
                fill: red;
                stroke: red;
                stroke-width: 1;
                cursor: pointer;
            }
            .circle:hover {
                stroke-width: 12;
            }
            .curve {
                transition-duration: 1s;
                fill: transparent;
                stroke: #ccc;
                stroke-width: 2;
            }
            svg {
                border: 1px solid black;
            }
        </style>
    </head>
        <svg width="100%" height="100%">
            <rect x="0" y="0" width="100%" height="100%" style="fill:red; "  class=""/>
            <path d="M 50% 50% L 100% 100% L 0% 100%" style="fill: #E5E5E5;stroke:black;stroke-width: 3px;" class=""/>
        </svg>
        <?php

            $datas = array(
                -8 => 98,
                -7 => 123,
                -6 => 12,
                -5 => -2,
                -4 => -72,
                -3 => -320,
                -2 => -65,
                -1 => -22,
                0 => 300,
                1 => 164,
                3 => 580,
                2 => 40,
                5 => 320,
                6 => 259,
                7 => 123,
                23 => 34,
            );

            // $graphic = new SvgGraphic($datas, array(
            //     'height' => '800px',
            //     'width' => '800px',
            //     'x' => array(-400, 400),                // array(int, int) | 'auto'
            //     'y' => array(-400, 400),                // array(int, int) | 'auto'
            //     'echelle' => array(1,1),                // array(int, int)
            //     'disableNegativeValue' => false,        // true | false
            //     'disableNegativeKey' => false,          // true | false
            //     'showSteps' => true,                    // true | false | array(true, false) | array(false, true)
            //     'steps' => 'in',                        // 'in' | 'out'
            //     'unities' => array(50, 10)
            //     'ksort' => true,                        // true | false
            //     'sort' => false,                        // true | false
            //     'style' => 'default';                   // StyleGraphic | 'nameOfADefinedStyle'
            // ));


            $svg = new Svg\Svg('100%', '100%');

            $svg->add(Svg\Shape\Shape::graphic($datas, new Svg\Shape\Point(0, 0), 100, 100, array(
                'percent' => true,
            )));

            $svg->display();
            ?>
    </body>
</html>