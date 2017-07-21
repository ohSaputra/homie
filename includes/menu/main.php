<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


	$class = 'menu';
	$prefix = 'page-menu';
	$nav = 'nav-menu';

	$walker = new MenuOptions\Build;

	$menu = $walker->html(array('walker' => new MenuOptions\Navigation(), 'menu' => 'C88Fin Menu', 'class' => $class, 'prefix' => $prefix, 'nav' => $nav, 'id' => '', 'level' => 0, 'depth' => 1));

	echo $menu;
?>