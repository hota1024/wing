<?php

/***
 * Return assets directory path + $path
 * @param string $path
 * @return string
 */
function asset($path = ''){
    return get_template_directory_uri().'/assets/'.$path;
}
