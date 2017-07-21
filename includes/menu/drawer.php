<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

    $class = 'menu';
    $prefix = 'drawer-menu';
    $nav = 'nav-tree';

    $walker = new MenuOptions\Build;
    $menu = $walker->html(array('walker' => new MenuOptions\Dropdown(), 'menu' =>  'C88 Drawer Menu', 'class' => $class, 'prefix' => $prefix, 'nav' => $nav, 'id' => '', 'level' => 0, 'depth' => 2));
?>