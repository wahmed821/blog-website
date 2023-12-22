<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Blog;
use Exception;
use DB;

class AppController extends Controller
{
    ## Index page
    public function index()
    {
        /*if (isset($_GET['query']) && !empty($_GET['query'])) {
            $q = $_GET['query'];
            $query->where('blog_title', 'LIKE',  "%$q%");
        }*/


        $query = Blog::with('categories');
        $query->where(['status' => 'active']);
        $blogs = $query->orderBy('id', 'desc')->paginate(2);

        $blogsWithCategories = $blogs->map(function ($blog) {
            $categoryNames = $blog->categories->pluck('category_name')->implode(', ');

            $blogData = $blog;
            $blogData->category_names = $categoryNames;
            return $blogData;
        });

        return view("index", compact('blogs', 'blogsWithCategories'));
    }

    ## About page
    public function aboutUs()
    {
        return view("about-us");
    }

    ## Contact page
    public function contactUs()
    {
        return view("contact-us");
    }

    ## Blogs page (by category)
    public function blogs($slug)
    {
        # Get the category ID by url slug
        $category = Category::select('*')
            ->where(['status' => 'active', 'url_slug' => $slug])
            ->first();

        if (!$category) {
            # Redirect to 404 - You need to create this
        }

        $cid = $category->id;
        $blogs = Blog::whereHas('categories', function ($query) use ($cid) {
            $query->where('category_id', $cid);
        })
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->paginate(2);

        return view("blogs", compact("blogs", "category"));
    }

    ## Single Blog page
    public function blog($slug)
    {
        //$blog = Blog::with('categories')->where(['status' => 'active', 'url_slug' => $slug]);
        $blog = Blog::where(['status' => 'active', 'url_slug' => $slug])->with('categories')->firstOrFail();

        if (!$blog) {
            # Redirect to 404 - You need to create this
        }

        $categoryNames = $blog->categories->pluck('category_name')->implode(', ');

        # Get all comments
        $comments = DB::table('blog_comments')
            ->where(['blog_id' =>  $blog->id, 'status' => 'active'])
            ->get();

        # Get related posts
        $categoryIds = $blog->categories->pluck('id')->implode(', ');
        $sql = "SELECT b.*, bcat.category_id
            FROM blogs as b
            join blog_categories as bcat on b.id = bcat.blog_id
            WHERE bcat.category_id in ($categoryIds) AND b.status = 'active' AND b.id != $blog->id
            ORDER BY b.id desc limit 5";
        $relatedPosts = DB::select($sql);

        # Get all categories
        $categories = DB::table('categories')
            ->where(['status' => 'active'])
            ->orderBy('category_name')
            ->get();

        return view("blog", compact('blog', 'categoryNames', 'comments', 'categories', 'relatedPosts'));
    }

    ## Submit comment funciton
    public function submitComment(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'full_name' => "required",
            'comment' => "required"
        ]);
        if ($validator->fails()) {
            $result = array('status' => false, 'message' => "Validation error occured");
            return response()->json($result, 400); // Bad Request
        }

        $comment_id = DB::table('blog_comments')->insertGetId([
            'full_name' => $request->full_name,
            'comment' => $request->comment,
            'blog_id' => $request->blog_id,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        if ($comment_id) {
            $result = array('status' => true, 'message' => "Comment posted successfuly", "comment_id" => $comment_id);
            $responseCode = 200; // Success
        } else {
            $result = array('status' => false, 'message' => "Something went wrong");
            $responseCode = 400; // Bad Request
        }

        return response()->json($result, $responseCode);
    }
}
