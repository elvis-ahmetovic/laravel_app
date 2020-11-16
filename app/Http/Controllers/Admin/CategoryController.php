<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    
    /*
     * Show category page
     */
    public function index()
    {
        // Categories
        $categories = Category::where('deleted', NULL)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin/categories')->with('categories', $categories);
    }

    /*
     * Add new category
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = new Category;
        $category->name = strtolower($request->input('name'));
        $category->save();

        return redirect()->to('admin/categories')->with('success', 'Succassfully added new category');
    }

    /*
     * Edit category
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'new-name' => 'required',
        ]);

        $category = Category::find($id);
        $category->name = strtolower($request->input('new-name'));
        $category->save();

        return redirect()->to('admin/categories')->with('success', 'Category was succassfully edited');
    }

    /*
     * Disable category
     */
    public function disable($id)
    {
        $category = Category::find($id);
        ($category->disabled === NULL) ? $category->disabled = 1 : $category->disabled = NULL;
        $category->save();

        return redirect()->to('admin/categories');
    }

    /*
     * Delete category
     */
    public function delete($id)
    {
        $category = Category::find($id);
        $category->deleted = 1;
        $category->save();

        return redirect()->to('admin/categories')->with('success', 'Category was succassfully deleted');;
    }
}
