<?php

function asset($path = ''){
    return get_template_directory_uri().'/assets/'.$path;
}
