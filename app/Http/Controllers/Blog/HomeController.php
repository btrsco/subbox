<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Blog $blog)
    {
        abort_if(!$blog->is_verified, 404);

        return Inertia::render('Blog/Home', [
            // ...
        ]);
    }
}
