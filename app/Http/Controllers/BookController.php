<?php

namespace App\Http\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;

class BookController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    //Function for book page index, where user can access to see the book and its catalogue, along with the details of the book
    public function index(Request $request)
    {


        $booksSearch = BukuModel::when($request->search, function ($query) use ($request){
            return $query->whereAny([
                "id",
                "title",
                "author",
                "description",
                "cover",
                "category_id",
                "created_at",
                "updated_at"
            ], $request->search);
        });

        if ($request->has('category') && $request->category != '') {
            $booksSearch->where('category_id', $request->category);
        }
        if ($request->has('author') && $request->author != '') {
            $booksSearch->where('author', $request->author);
        }
        if ($request->has('booktitle') && $request->booktitle != '') {
            $booksSearch->where('title', 'like', '%' . $request->booktitle . '%');
        }

        $books = $booksSearch->paginate(10);
        $categories = KategoriModel::all();
        $authors = BukuModel::all([
            "author"
        ]);

        return view('books.index', compact('books', 'categories', 'authors'));
    }

    //Function for book page CRUD Purposes, where only admin that can access this section of the controller routing.

    //This Method Initiate the page to add books.
    public function create(Request $request)
    {
        $booksSearch = BukuModel::when($request->search, function ($query) use ($request){
            return $query->whereAny([
                "id",
                "title",
                "author",
                "description",
                "cover",
                "category_id",
                "created_at",
                "updated_at"
            ], $request->search);
        });
        if ($request->has('category') && $request->category != '') {
            $booksSearch->where('category_id', $request->category);
        }
        if ($request->has('author') && $request->author != '') {
            $booksSearch->where('author', $request->author);
        }
        if ($request->has('booktitle') && $request->booktitle != '') {
            $booksSearch->where('title', 'like', '%' . $request->booktitle . '%');
        }

        $books = $booksSearch->paginate(10);
        $categories = KategoriModel::all();
        $authors = BukuModel::all([
            "author"
        ]);
        return view('books.crudBook', compact('books', 'categories', 'authors'));
    }

    //This method add new books and save it to to the databse, along with the cover image. The cover image also saved in the laravel project and in the database as intended by the task.
    //it is required to run -> "php artisan storage:link" so allowing the images to be publicly accessible by linking the "public/storage" directory to the "storage/app/public" folder
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:kategori,id',
            'cover' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {

            $validated['cover'] = $request->file('cover')->store('uploads', 'public');


            // $validated['cover'] = $request->file('cover')->move(public_path('uploads'), $request->file('cover')->getClientOriginalName());

            // Save the cover image to the public/uploads directory
            $coverImage = $request->file('cover');
            // $coverImageName = $coverImage->getClientOriginalName();
            $coverImage->move(public_path('uploads'), $request->file('cover')->getClientOriginalName()); // Save the image directly in public/uploads
        }

        BukuModel::create($validated);

        return redirect()->route('books.create')->with('success', 'Book added successfully.');
    }

    public function show(BukuModel $book)
    {
        return view('books.bookDetails', compact('book'));
    }

    //This Method Initiate the page to edit information in already existing books.
    public function edit(Request $request)
    {
        $booksSearch = BukuModel::when($request->search, function ($query) use ($request){
            return $query->whereAny([
                "id",
                "title",
                "author",
                "description",
                "cover",
                "category_id",
                "created_at",
                "updated_at"
            ], $request->search);
        });
        if ($request->has('category') && $request->category != '') {
            $booksSearch->where('category_id', $request->category);
        }
        if ($request->has('author') && $request->author != '') {
            $booksSearch->where('author', $request->author);
        }
        if ($request->has('booktitle') && $request->booktitle != '') {
            $booksSearch->where('title', 'like', '%' . $request->booktitle . '%');
        }

        $books = $booksSearch->paginate(10);
        $id = $request->input('id');
        $book = BukuModel::findOrFail($id);
        $categories = KategoriModel::all();
        $authors = BukuModel::all([
            "author"
        ]);
        return view('books.crudBook', compact('books', 'book', 'categories', 'authors'));
    }

    //This Method updated the new information for the book that are inputted in the corresponding page.
    public function update(Request $request, BukuModel $book)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'author' => 'required|string',
            'category_id' => 'required|exists:kategori,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            // Delete old image if it exists
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('uploads', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.crudBook')->with('success', 'Book updated successfully.');
    }

    //This Method delete book from the database model and the corresponding resource such as cover image that is saved both in the laravel project and its path string in the database.
    public function destroy(BukuModel $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()->route('books.crudBook')->with('success', 'Book deleted successfully.');

    }
}
