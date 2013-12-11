<?php 

/* ERROR REPORTING */
error_reporting(E_ALL);
ini_set("display_errors", 1);


require 'autoloader.php';



?>
<!DOCTYPE>
    <head>
        <title>Tests</title>
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
    <body>
        <?php
            $svg = new Svg\Svg(800, 800);

            $svg->add(Svg\Shape\Shape::graphic(array(
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
                2 => 40,
                3 => 380,
                5 => 320,
                6 => 259,
                7 => 123,
            )->orderDatas()));
            ?>
    </body>
</html>