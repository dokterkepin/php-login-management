<?php

namespace dokterkepin\Belajar\PHP\MVC\App;

class View
{
    static function render(string $view, array $model): void{
        require __DIR__ . "/../View/$view.php";
    }
}