<?php

$paths = array (
            "lib",
            "lib/controllers",
            "lib/models",
            "lib/view",
            "lib/subsidiary",
            "admin/lib",
            "admin/lib/controllers",   
            "admin/lib/subsidiary"
        );

$finalpath = '';
foreach ($paths as $path) {
    $finalpath .= $path.PATH_SEPARATOR;
}

set_include_path(get_include_path().PATH_SEPARATOR.$finalpath);   //Setting including of files form directories lib and admin/lib


?>