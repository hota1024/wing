# wing
<img src="https://user-images.githubusercontent.com/24543982/35212664-41168014-ff9e-11e7-834b-663d86e4bfe3.png" width="128px" height="auto">

# Version
This is version beta.

# About wing
wing is a wordpress API wrapper library.

# API Reference

# Folders
## assets
css/js/images

## wing_core
PHP files of wing.

# API
## asset()
Return assets directory path + parameter($path)

## Customizer - class
Customizer class is a wrapper class of wordpress CustomizerAPI.

Declare a CustomizerClass object in `functions.php`.

Declare sample.

```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
```

### Add field

#### Text
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addText('sample_text','sample_label','default value');
```

#### Checkbox
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addCheckbox('sample_checkbox','sample_label', true/*default*/);
```

#### Select
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addSelect('sample_select','sample_label',['choice1' => 'value1','choice2' => 'value2'], 'choice2');
```

#### Radio
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addRadio('sample_radio','sample_label', ['radio1' => 'value1','radio2' => 'value2',], 'radio1');
```

#### Color
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addColor('sample_color','sample_label','#00aaff');
```

### Get field value

#### data()

This function is return array of field object.
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addCheckbox('runprocess','Run process',false);

if($SampleCustomizer->data()->runprocess->get()){
    //process
}
```

#### get($id)
This function is return field value.
```functions.php
<?php
include "wing_core/autoload.php";

//Declare customizer
$SampleCustmizer = new Customizer('sample_section', 'sample_title');
$SampleCustomizer->addCheckbox('runprocess','Run process',false);

if($SampleCustomizer->get('runprocess')){
    //process
}
```

## Parts(class)
### Parts::header() / Parts::footer()
`Parts::header()` is `get_header()` wrapper method.
`Parts::footer()` is `get_footer()` wrapper method.

#### demo
```index.php
<?php Parts::header()?>
<?php Parts::footer()?>
```

## GlobalVariable(class)
This is global variable manage class.

### DEMO
```functions.php
<?php
//Load wing
include 'wing_core/autoload.php';

//Declare customizer
$ShowHelloworld = new Customizer('show', 'show');
$ShowHelloworld->addCheckbox('show_helloworld','Show helloworld',true);

GlobalVariable::register('ShowHelloworld', $ShowHelloworld);
```

```index.php
<?php if(gv()->ShowHelloworld->get('show_helloworld')):?>
    <h1>Helloworld</h1>
<?php endif;?>
```

