<?php

namespace App\Http\Controllers\Dashboard;

use App\Blog;
use App\Donor;
use App\BlogSection;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use App\Jobs\SendEmailsToUsers​;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\BlogRequest;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_blogs'])->only(['index', 'show']);
        $this->middleware(['permission:create_blogs'])->only('create');
        $this->middleware(['permission:update_blogs'])->only('edit');
        $this->middleware(['permission:delete_blogs'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $blogs = Blog::query()->with('blog_section:id,title');

        if ($keyword != null) {
            $blogs = $blogs->search($keyword);
        }

        $blogs = $blogs->orderBy($sort_by, $order_by);
        $blogs = $blogs->paginate($limit_by);
        return view('dashboard.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $sections = BlogSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.blogs.create', compact('sections'));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();
        // image
        $img    = $request->file('img');
        $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
        $path           = storage_path('app/public/uploads/blogs/' . $filename);
        Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);
        $data['img'] = $filename;

        $data = Blog::create($data);
        dispatch(new SendEmailsToUsers​($data));

        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.blogs.index');
    }

    public function edit($id)
    {
        $blog = Blog::whereId($id)->first();
        if($blog) {
            $sections = BlogSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.blogs.edit', compact('blog', 'sections'));
        }
        return redirect()->route('dashboard.blogs.index');
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::whereId($id)->first();
        if($blog) {
            $data = $request->validated();
            // blog image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/blogs/' . $blog->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/blogs/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            $blog->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.blogs.index');
        }
        return redirect()->route('dashboard.blogs.index');
    }

    public function destroy($id)
    {
        $blog = Blog::whereId($id)->first();
        if($blog) {
            Storage::disk('public')->delete('/blogs/' . $blog->img);
            $blog->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.blogs.index');
        }
        return redirect()->route('dashboard.blogs.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $blogs = Blog::select('id', 'img')->whereIn('id', $ids)->get();
        if ($blogs) {
            foreach ($blogs as $blog) {
                Storage::disk('public')->delete('/blogs/' . $blog->img);
                $blog->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.blogs.index');
    }
}
