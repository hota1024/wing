<?php

class CustomizerField{
    private $name;

    /**
     * CustomizerField constructor.
     * @param $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Return $this->fields value
     * @return string
     */
    function get(){
        return get_theme_mod($this->name);
    }

    /**
     * Set $this->fields value
     * @param $value
     * @return $this
     */
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

    /**
     * Customizer constructor.
     * @param $section
     * @param $title
     */
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

    /**
     * Get $this->fields by id
     * If $id is empty, return array of $this->fields object.
     * @param string $id
     * @return object|string
     */
    function get($id = '*'){
        if($id != '*') return (new CustomizerField($this->fieldsName($id)))->get();
        $result = [];
        foreach($this->fields as $field){
            $result[$field] = (new CustomizerField($this->fieldsName($field)))->get();
        }
        return (object)$result;
    }

    private function fieldsName($id,bool $tag = false){
        return $this->section.'_'.$id;
    }

    private function addField($id){
        $this->fields[] = $id;
    }

    /**
     * Return array of field object
     * @return object
     */
    public function data(){
        $result = [];
        foreach($this->fields as $field){
            $result[$field] = new CustomizerField($this->fieldsName($field));
        }
        return (object)$result;
    }

    /**
     * Add text field
     * @param $id
     * @param $label
     * @param string $default
     */
    function addText($id,$label,$default = ''){
        $this->addField($id);
        add_action('customize_register',function($customize) use ($id,$label,$default){
            $customize->add_setting($this->fieldsName($id), [
                'default'   => $default,
                'transport' => 'postMessage',
            ]);
            $customize->add_control( $this->fieldsName($id), [
                'settings'  => $this->fieldsName($id),
                'label'     => $label,
                'section'   => 'my_theme_origin_scheme_'.$this->section,
                'type'      => 'text',
            ]);
        });
    }

    /**
     * Add checkbox field
     * @param $id
     * @param $label
     * @param bool $default
     */
    function addCheckbox($id,$label,$default = false){
        $this->addField($id);
        add_action('customize_register',function($customize) use ($id,$label,$default){
            $customize->add_setting($this->fieldsName($id),[
                'default' => $default,
            ]);
            $customize->add_control($this->fieldsName($id), [
                'settings' => $this->fieldsName($id),
                'label' => $label,
                'section' => 'my_theme_origin_scheme_'.$this->section,
                'type' => 'checkbox',
            ]);
        });
    }

    /**
     * Add select field
     * @param $id
     * @param $label
     * @param $choices
     * @param $default
     */
    function addSelect($id,$label,$choices,$default){
        $this->addField($id);
        add_action('customize_register',function($customize) use ($id,$label,$choices,$default){
            $customize->add_setting($this->fieldsName($id),[
                'default' => $default,
            ]);
            $customize->add_control($this->fieldsName($id), [
                'settings' => $this->fieldsName($id),
                'label' => $label,
                'section' => 'my_theme_origin_scheme_'.$this->section,
                'type' => 'select',
                'choices' => $choices,
            ]);
        });
    }

    /**
     * Add radio box field
     * @param $id
     * @param $label
     * @param $choices
     * @param $default
     */
    function addRadio($id,$label,$choices,$default){
        add_action('customize_register',function($customize) use ($id,$label,$choices,$default){
            $customize->add_setting($this->fieldsName($id),[
                'default' => $default,
            ]);
            $customize->add_control($this->fieldsName($id), [
                'settings' => $this->fieldsName($id),
                'label' => $label,
                'section' => 'my_theme_origin_scheme_'.$this->section,
                'type' => 'radio',
                'choices' => $choices,
            ]);
        });
    }

    /**
     * Add color field
     * @param $id
     * @param $label
     * @param string $default
     */
    function addColor($id,$label,$default = '#ffffff'){
        add_action('customize_register',function($customize) use ($id,$label,$default){
            $customize->add_setting($this->fieldsName($id),[
                'default' => $default,
            ]);
            $customize->add_control(new WP_Customize_Color_Control(
                $customize, $this->fieldsName($id),
                [
                    'settings' => $this->fieldsName($id),
                    'label' => $label,
                    'section' => 'my_theme_origin_scheme_'.$this->section,
                ]
            ));
        });
    }
}