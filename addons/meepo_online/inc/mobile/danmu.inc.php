<?php
global $_W,$_GPC;
$barrages=
array(
    array(
        'info'   => '第一条弹幕',
        'img'    => 'http://yaseng.github.io/jquery.barrager.js/static/img/heisenberg.png',
        'href'   => 'http://www.yaseng.org',

        ),
    array(
        'info'   => '第二条弹幕',
        'img'    => 'static/img/yaseng.png',
        'href'   => 'http://yaseng.github.io/jquery.barrager.js/static/img/heisenberg.png',
        'color'  =>  '#ff6600'

        ),
    array(
        'info'   => '第三条弹幕',
        'img'    => 'http://yaseng.github.io/jquery.barrager.js/static/img/heisenberg.png',
        'href'   => 'http://www.yaseng.org',
        'bottom' => 70 ,

        ),
    array(
        'info'   => '第四条弹幕',
        'href'   => 'http://yaseng.github.io/jquery.barrager.js/static/img/heisenberg.png',
        'close'  =>false,

        ),

    );
echo  json_encode($barrages[array_rand($barrages)]);