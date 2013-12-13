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
                
            }
        </style>
    </head>
    <body style="margin: 0px;">
        <!--<svg width="100%" height="100%">
            <rect x="0" y="0" width="100%" height="100%" style="fill:red; "  class=""/>
            <path d="M 50% 50% L 100% 100% L 0% 100%" style="fill: #E5E5E5;stroke:black;stroke-width: 3px;" class=""/>
            <line x1="50%" y1="50%" x2="100%" y2="100%" stroke="red" />
        </svg>-->
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

            $svg->add(Svg\Shape\Shape::graphic($datas, new Svg\Shape\Point(10, 10), 800, 100, array(
            )));
            $svg->add(Svg\Shape\Shape::graphic($datas, new Svg\Shape\Point(50, 50), 1400, 900, array(
            )));
            $svg->add(Svg\Shape\Shape::graphic($datas, new Svg\Shape\Point(100, 200), 800, 300, array(
            )));

            $svg->display();
            ?>
    </body>
</html>