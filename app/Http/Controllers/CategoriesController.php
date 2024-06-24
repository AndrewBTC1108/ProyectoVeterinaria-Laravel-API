<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\AdminCategoriesCollection;
use App\Http\Resources\Categories\CategoriaCollection;
use App\Http\Resources\Categories\DoctorCategoriesCollection;
use App\Models\AdminCategories;
use App\Models\Categoria;
use App\Models\DoctorCategories;

// use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function index(): CategoriaCollection
    {
        return new CategoriaCollection(Categoria::all());

    }

    public function adminCategories(): AdminCategoriesCollection
    {
        return new AdminCategoriesCollection(AdminCategories::all());
    }

    public function doctorCategories(): DoctorCategoriesCollection
    {
        return new DoctorCategoriesCollection(DoctorCategories::all());
    }
}
