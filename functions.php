<?php
include 'wing_core/autoload.php';

//Define Customizers
$ColorCustomizer = new Customizer('color','色');
$ColorCustomizer->addColor('background','背景');

//Define NavMenus
NavMenu::Init();
$MainNav = new NavMenu('top','ページの上。');
$MainNav->set([
    'menu' => 'MainNav,MainNav,MainNav'
]);

//Register Global Variables
GlobalVariable::register('ColorCustomizer', $ColorCustomizer);
GlobalVariable::register('MainNav', $MainNav);
