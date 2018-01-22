<?php

class CustomizerField{
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    function get(){
        return get_theme_mod($this->name);
    }

    function set($value){
        set_theme_mod($this->name,$value);
        return $this;
    }
}

class Customizer {
    static $count = 0;
    private $section;
    private $fields = [];
    private $data = [];

    function __construct($section,$title)
    {
        $this->section = $section;
        add_action('customize_register',function($customize) use ($title){
            $customize->add_section( 'my_theme_origin_scheme_'.$this->section, [
                'title'     => $title,
            ]);
        });
        static::$count++;
    }

    function get($id = '*'){
        if($id != '*') return (new CustomizerField($this->filedName($id)))->get();
        $result = [];
        foreach($this->fields as $field){
            $result[$field] = (new CustomizerField($this->filedName($field)))->get();
        }
        return (object)$result;
    }

    public function filedName($id,bool $tag = false){
        return $this->section.'_'.$id;
    }

    private function addField($id){
        $this->fields[] = $id;
    }

    public function data(){
        $result = [];
        foreach($this->fields as $field){
            $result[$field] = new CustomizerField($this->filedName($field));
        }
        return (object)$result;
    }

    function addText($id,$label,$default = ''){
        $this->addField($id);
        add_action('customize_register',function($customize) use ($id,$label,$default){
            $customize->add_setting($this->filedName($id), [
                'default'   => $default,
                'transport' => 'postMessage',
            ]);
            $customize->add_control( $this->filedName($id), [
                'settings'  => $this->filedName($id),
                'label'     => $label,
                'section'   => 'my_theme_origin_scheme_'.$this->section,
                'type'      => 'text',
            ]);
        });
    }

    function addCheckbox($id,$label,$default = false){
        $this->addField($id);
        add_action('customize_register',function($customize) use ($id,$label,$default){
            $customize->add_setting($this->filedName($id),[
                'default' => $default,
            ]);
            $customize->add_control($this->filedName($id), [
                'settings' => $this->filedName($id),
                'label' => $label,
                'section' => 'my_theme_origin_scheme_'.$this->section,
                'type' => 'checkbox',
            ]);
        });
    }

    function addSelect($id,$label,$choices,$defualt){
        $this->addField($id);
        add_action('customize_register',function($customize) use ($id,$label,$choices,$defualt){
            $customize->add_setting($this->filedName($id),[
                'default' => $defualt,
            ]);
            $customize->add_control($this->filedName($id), [
                'settings' => $this->filedName($id),
                'label' => $label,
                'section' => 'my_theme_origin_scheme_'.$this->section,
                'type' => 'select',
                'choices' => $choices,
            ]);
        });
    }

    function addRadio($id,$label,$choices,$defualt){
        add_action('customize_register',function($customize) use ($id,$label,$choices,$defualt){
            $customize->add_setting($this->filedName($id),[
                'default' => $defualt,
            ]);
            $customize->add_control($this->filedName($id), [
                'settings' => $this->filedName($id),
                'label' => $label,
                'section' => 'my_theme_origin_scheme_'.$this->section,
                'type' => 'radio',
                'choices' => $choices,
            ]);
        });
    }

    function addColor($id,$label,$defualt = '#ffffff'){
        add_action('customize_register',function($customize) use ($id,$label,$defualt){
            $customize->add_setting($this->filedName($id),[
                'default' => $defualt,
            ]);
            $customize->add_control(new WP_Customize_Color_Control(
                $customize, $this->filedName($id),
                [
                    'settings' => $this->filedName($id),
                    'label' => $label,
                    'section' => 'my_theme_origin_scheme_'.$this->section,
                ]
            ));
        });
    }
}