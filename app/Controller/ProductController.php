<?php

namespace dokterkepin\Belajar\PHP\MVC\Controller;

class ProductController
{
    public function categories(string $productId, string $categoryId): void{
        echo "PRODUCT $productId, CATEGORY $categoryId";
    }
}