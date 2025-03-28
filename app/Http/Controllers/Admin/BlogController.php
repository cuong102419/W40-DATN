<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'author' => 'required|string|min:3|max:100',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('uploads/blogs', 'public');
        }



        $blog = Blog::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm bài viết thành công!',
            'data' => $blog
        ]);
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'author' => 'required|string|min:3|max:100',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            Storage::disk('public')->delete($blog->image_url);
            $data['image_url'] = $request->file('image_url')->store('uploads/blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin-blog.index')->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        Storage::disk('public')->delete($blog->image_url);
        $blog->delete();

        return redirect()->route('admin-blog.index')->with('success', 'Bài viết đã được xóa!');
    }
}
