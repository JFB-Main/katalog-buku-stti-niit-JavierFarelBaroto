<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;

class CategoryController extends Controller
{
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $categories = KategoriModel::all();
        return view('categories.index', compact('categories'));
    }

    //Initiates the Catalog CRUD Page
    public function create(Request $request)
    {

         $categoriesinitiate = KategoriModel::when($request->search, function ($query) use ($request){
            return $query->whereAny([
                "id",
                "name",
                "created_at",
                "updated_at"
            ], $request->search);
        });
        $categorySearchResult = $categoriesinitiate->paginate(10);
        $catCrud = $categorySearchResult;
        return view('category.crudCategory', compact('catCrud'));
    }

    //Stores newly added catalog type from inputting process in the catalog CRUD Page. The data are saved to the database model
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:kategori,name',
        ]);

        KategoriModel::create($validated);

        return redirect()->route('category.crudCategory')->with('success', 'Category added successfully.');
    }

 
    public function show(KategoriModel $category)
    {
        return view('categories.show', compact('category'));
    }

    //Initiates the Catalog Edit Page
    public function edit(Request $request)
    {
        $categorySearch = KategoriModel::when($request->search, function ($query) use ($request){
            return $query->whereAny([
                "id",
                "name",
                 "created_at",
                "updated_at"
            ], $request->search);
        });

        $categorySearchResult = $categorySearch->paginate(10);
        $id = $request->input('id');
        $catCrud = $categorySearchResult;
        $catEdit = KategoriModel::findOrFail($id);
        return view('category.crudCategory', compact('catCrud', 'catEdit'));
    }

    //Updates an already existing catalog data in the database. The data are saved to the database model
    public function update(Request $request, KategoriModel $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:kategori,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('category.crudCategory')->with('success', 'Category updated successfully.');
    }

    //delete specific catalog data that we want to delete
    public function destroy(KategoriModel $category)
    {
        $category->delete();
        return redirect()->route('category.crudCategory')->with('success', 'Category deleted successfully.');

    }
}
