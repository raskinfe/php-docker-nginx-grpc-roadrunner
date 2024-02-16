<?php

namespace App\Services;
class View {

    static function make(string $path, array $args = null) {
        $realPath = implode('/', explode('.', $path)) . '.php';
        if($args !== null && count($args)) {
            foreach($args as $key => $arg) { 
                $$key = $arg;
            }
        }

        include base().'/src/views/'.$realPath;
    }

}