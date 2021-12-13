<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Structure\Repositories\DropdownRepository;

class DropdownService
{
    protected $dropdownRepository;

    public function __construct
    (
        DropdownRepository $dropdownRepository
    )
    {
        $this->dropdownRepository = $dropdownRepository;
    }

    public function CategoryDropdown($discriminator)
    {
        return $this->dropdownRepository->categoryDropdown($discriminator);
    }
}
