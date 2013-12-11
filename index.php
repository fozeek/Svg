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
            )));

            $svg->display();
            ?>

            <svg version="1.1" id="mustach" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         width="100px" height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
<path d="M83.5,63.833c-50.833,29-67.167-26.166-67.167-26.166s11.333,19.333,33.333,0c22-19.333,34-6,34-6L83.5,63.833z"/>
</svg>
    </body>
</html>