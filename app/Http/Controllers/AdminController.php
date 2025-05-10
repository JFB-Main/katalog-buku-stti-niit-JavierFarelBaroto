<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        public function __construct()
    {
        $this->middleware('auth');
    }

        //Initiates the Admin Dashboard Page that is connected to various CRUD Pages.
        public function dashboard()
    {
        $totalBooks = BukuModel::count();
        $totalCategories = KategoriModel::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('totalBooks', 'totalCategories', 'totalUsers'));
    }
}
