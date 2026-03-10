<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return view('user.dashboard', compact('books'));
    }

    public function books()
    {
        $books = Book::all();

        return view('user.book', compact('books'));
    }

    public function aboutUs()
    {
        return view('user.about-us');
    }
}
