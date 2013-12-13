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
            .path-curve {
                transition-duration: 1s;
                fill: transparent;
                stroke: #16873c;
                stroke-width: 2;
            }
            .full-curve {
                fill: rgba(235,253,235,0.7);
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
                 -41 => -874,
                // -40 => 650,
                // -8 => 98,
                // -7 => 123,
                // -6 => 12,
                // -5 => -2,
                // -4 => -72,
                // -3 => -320,
                // -2 => -65,
                // -1 => -22,
                // 0 => 300,
                // 1 => 164,
                // 3 => 580,
                21 => 140,
                15 => 320,
                16 => 259,
                17 => 123,
                -123 => 34,
            );

            $svg = new Svg\Svg('100%', '100%');
            
            $svg->add(Svg\Shape\Shape::graphic($datas, array(
                'anchor' => new Svg\Shape\Point(100, 100),
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