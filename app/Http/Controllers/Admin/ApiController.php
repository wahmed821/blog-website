<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Blog;
use Exception;
use Auth;
use DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function __construct()
    { }

    ## Function to get categories
    public function getCategories()
    {
        $categories = Category::select('*')->with('user')->orderBy('id', 'desc')->get();
        $result = array('status' => true, 'message' => count($categories) . " record found", 'data' => $categories);
        return response()->json($result);
    }

    ## Function to get blogs
    public function getBlogs()
    {
        $blogs = Blog::select('*')->with('user')->orderBy('id', 'desc')->get();
        $result = array('status' => true, 'message' => count($blogs) . " record found", 'data' => $blogs);
        return response()->json($result);
    }
}
