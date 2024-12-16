<?php

namespace App\Faker;

use Faker\Provider\Base;

class ImageProvider extends Base
{
    // Méthode pour générer une URL d'image aléatoire
    public function imageUrl($width = 400, $height = 300, $category = 'abstract')
    {
        return "https://picsum.photos/{$width}/{$height}?category={$category}";
    }
}
