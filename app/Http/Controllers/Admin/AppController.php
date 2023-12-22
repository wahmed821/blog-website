<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use Exception;
use Auth;
use DB;
use Carbon\Carbon;

class AppController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    ## Dashboard
    public function dashboard()
    {
        $data['categories'] = Category::select('id')->get()->count();
        $data['blogs'] = Blog::select('id')->get()->count();
        $data['comments'] = DB::table('blog_comments')->select('id')->get()->count();
        $data['today_blogs'] = Blog::select('id')->whereDate('created_at', Carbon::today())
            ->get()->count();

        return view('admin.dashboard', $data);
    }

    ## Categories function
    public function categories()
    {
        $categories = Category::select('*')->with('user')->orderBy('id', 'desc')->get();
        return view("admin.categories.index", compact('categories'));
    }

    ## Add Category function
    public function addCategory()
    {
        return view('admin.categories.add');
    }

    ## Edit Category function
    public function editCategory($id)
    {
        # Validation of parameter ID, you need to apply

        # Call the category data
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    ## Function to insert/update category in DB
    public function storeCategory(Request $request)
    {
        ## Validation - Todo (You need to do this)
        try {
            $param = $request->all();
            unset($param['_token']);
            $param['user_id'] = Auth::user()->id;

            # Update category
            if (isset($request->id)) {
                unset($param['_method']); // if PUT route is defined
                Category::where('id', $param['id'])->update($param);
                $msg = "Category has been updated successfully";
            }
            # Insert
            else {
                Category::create($param);
                $msg = "Category has been created successfully";
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        # Redirect to all categories
        return redirect()->route('categories')->withStatus($msg);
    }

    ## Blogs function
    public function blogs()
    {
        $blogs = Blog::select('*')->with('user')->orderBy('id', 'desc')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    ## Add Blog function
    public function addBlog()
    {
        # Get all active categories
        $data['categories'] = Category::select('id', 'category_name')
            ->where('status', 'active')
            ->orderBy('category_name')->get();
        return view('admin.blogs.add', $data);
    }

    ## Edit Blog function
    public function editBlog($id)
    {
        # Validation of parameter ID, you need to apply

        # Get all active categories
        $data['categories'] = Category::select('id', 'category_name')
            ->where('status', 'active')
            ->orderBy('category_name')->get();

        # Call the Blog data
        $data['blog'] = Blog::find($id);

        # Get all blog categories in comma seperated
        $blog_categories = DB::table('blog_categories')
            ->where('blog_id', $id)
            ->pluck('category_id')
            ->implode(',');
        $data['blog_categories'] = explode(",",  $blog_categories);

        return view('admin.blogs.edit', $data);
    }

    ## Function to insert/update blog in DB
    public function storeBlog(Request $request)
    {
        ## Validation - Todo (You need to do this)
        try {
            $param = [
                'blog_title' => $request->blog_title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => Auth::user()->id
            ];

            # Display on Home condition
            $param['display_on_home'] = ($request->display_on_home == 1) ? 1 : 0;

            # Generate the url slug
            $param['url_slug'] = $this->generateUrlSlug($request->blog_title, 'blogs');

            # Handle the file upload
            if ($request->file('image')) {
                # Get the file from the request
                $file = $request->file('image');

                # Generate a unique name for the file
                $fileName = time() . '_' . $file->getClientOriginalName();

                # Move the file to the public/storage directory
                $file->move(public_path('uploads'), $fileName);

                # Folder path to store in DB
                $param['image'] = 'uploads/' . $fileName;
            }

            # Update blog
            if (isset($request->id)) {
                $blog_id = $request->id;
                Blog::where('id', $blog_id)->update($param);
                $msg = "Blog has been updated successfully";
            }
            # Insert
            else {
                $blog = Blog::create($param);
                $blog_id = $blog->id;
                $msg = "Blog has been created successfully";
            }

            # Create the entry of blog categories
            if (isset($request->category_id) && count($request->category_id)) {

                # Delete all existing blog
                DB::table('blog_categories')->where('blog_id', $blog_id)->delete();

                # Insert as new record
                foreach ($request->category_id as $cid) {
                    $cParam = ['blog_id' => $blog_id, 'category_id' => $cid];
                    DB::table('blog_categories')->insert($cParam);
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        # Redirect to all blogs
        return redirect()->route('blogs')->withStatus($msg);
    }

    ## View Blog function
    public function blog($id)
    {
        # Validation of parameter ID, you need to apply

        # Call the category data
        $data['blog'] = Blog::find($id);

        # Get all blog categories
        $data['blog_categories'] = DB::table('blog_categories as bcat')
            ->join('categories as c', 'bcat.category_id', '=', 'c.id')
            ->select('bcat.id', 'bcat.category_id', 'c.category_name')
            ->where('bcat.blog_id', $id)
            ->get();

        # Get all blog comments
        $data['comments'] = DB::table('blog_comments')
            ->where('blog_id', $id)
            ->get();

        return view('admin.blogs.blog', $data);
    }

    ## Function to change status
    public function updateStatus($table, $id, $value)
    {
        $param = array('status' => $value);
        $where = array('id' => $id);
        $update = DB::table($table)->where('id', $id)->update($param);
        if ($update) {
            $action = ($value == 'active') ? 'activated' : 'inactivated';
            return redirect()->back()->withStatus("Record has been successfully " . $action);
        } else {
            return redirect()->back()->withError("Something went wrong, please try again");
        }
    }

    ## Function to generate unique slug, for different tables
    public static function generateUrlSlug($title, $table)
    {
        // Convert the title to a URL-friendly format
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-'));

        // If the slug is empty, set a default
        if (empty($slug)) {
            $slug = 'untitled';
        }

        // Fetch existing slugs from the table
        $existing_url_slugs = DB::table($table)->pluck('url_slug')->implode(',');
        $existingSlugs = explode(",",  $existing_url_slugs);

        // If the slug already exists, append a suffix
        $originalSlug = $slug;
        $suffix = 2;

        while (in_array($slug, $existingSlugs)) {
            $slug = $originalSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    public function staffProfile()
    {
        return "<h1>Hello " . Auth::user()->name . "</h1>";
    }
}
