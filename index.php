<?php require 'autoloader.php' ?>
<!DOCTYPE>
    <head>
        <title>Svg</title>
        <style>
            .circle {
                transition-duration: 0.5s;
                fill: #1db34f;
                stroke: #16873c;
                stroke-width: 2px;
                cursor: pointer;
                box-shadow: 0px 0px 200px black;
            }
            .circle:hover {
                /*stroke-width: 10px;*/
            }
            .curve {
                transition-duration: 1s;
                fill: transparent;
                stroke: #ccc;
                stroke-width: 2;
            }
            svg {
                
            }

            svg .curve {
                stroke: #1db34f;
                stroke-width: 2px;
                stroke-opacity: 1;
                fill: none;
            }
        </style>
    </head>
    <body style="margin: 0px;">
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

            $svg = new Svg\Svg('100%', '100%');
            
            $svg->add(Svg\Shape\Shape::graphic($datas, array(
                'anchor' => new Svg\Shape\Point(100, 200),
                'width' => 1400,
                'height' => 800,
                'steps' => array(
                    'minXGap' => 100,
                ),
            )));

            $svg->display();
            ?>
    </body>
</html>