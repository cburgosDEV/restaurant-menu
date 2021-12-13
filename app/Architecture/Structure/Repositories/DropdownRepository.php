<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\Category;

class DropdownRepository
{
    public function categoryDropdown($discriminator)
    {
        return Category::select('category.id as value', 'category.name as text')
            ->where('category.discriminator', $discriminator)
            ->where('category.state', true)
            ->get();
    }
}
