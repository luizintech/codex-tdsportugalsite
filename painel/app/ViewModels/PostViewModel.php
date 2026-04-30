<?php

namespace App\ViewModels;

class PostViewModel extends PaginationViewModel {
    public $objectReturn;
    public $message;
    public $isEditing;
    public $editId;
    public $labels;
    public $categories;
    public $medias;
    public $selectedLabels;
    public $selectedCategories;
    public $selectedMediaId;
}
