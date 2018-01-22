<?php
class NavMenu{
    private $id;
    public $default = [
        'menu'            => '',
        'menu_class'      => 'menu',
        'container'       => 'div',
        'container_id'    => '',
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'echo'            => true,
        'depth'           => 0,
        'walker'          => '',
        'theme_location'  => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    ];

    static function Init(){
        add_theme_support('menus');
    }

    function __construct($id, $description)
    {
        $this->id = $id;
        $this->default['theme_location'] = $id;
        register_nav_menu($id, $description);
    }

    function set($data){
        foreach($data as $key => $datum){
            if($key == 'theme_location') continue;
            $this->default[$key] = $datum;
        }
    }

    function show($theme_location = false){
        wp_nav_menu($this->default);
    }
}