<?php

namespace App\Http\Controllers\Api;

//import Model "Buku"
use App\Models\Buku; 

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class BookApiController extends Controller 
{
    public function index() { 
        // Mengambil 5 data buku terbaru (latest) dan melakukan pagination
        $books = Buku::latest()->paginate(5); 

        // Mengembalikan instance BookResource dengan parameter (status, message, resource)
        return new BookResource(true, 'List Data Buku', $books); 
    }
}