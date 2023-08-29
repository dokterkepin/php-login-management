<?php

namespace dokterkepin\Belajar\PHP\MVC\App;

use dokterkepin\Belajar\PHP\MVC\App\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender(){
        View::render("Home/index", [
            "title" => "PHP Login Management"]);
        self::expectOutputRegex("[html]");
        self::expectOutputRegex("[body]");
        self::expectOutputRegex("[Your Password]");
        self::expectOutputRegex("[delivr]");
    }
}
