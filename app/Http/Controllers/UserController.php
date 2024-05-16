<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blog_comment;
use App\Models\Blog_like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /* Function for add blog admin side*/
    public function blogs()
    {
        return view('blogs.add_blog');
    }
    /* Blog list show in user side*/
    public function list()
    {
        try {
            $blogs = Blog::with('blog_like')->with('blog_comment')->paginate(5);

            return view('blogs.list', compact('blogs'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

/* Function for save blog admin side*/
    public function save_blog(Request $request)
    {

        try {

            $blog = new Blog();
            $blog->title = $request->title;
            $blog->description = $request->description;
            $imageName = '';
            if ($image = $request->file('blog_image')) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images', $imageName);
            }
            $blog->image = $imageName;
            $blog->save();
            return redirect()->route('add_blogs');

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function blog_like(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $blog_id = $request->blog_id;

            $count = Blog_like::where('blog_id', $blog_id)->where('user_id', $user_id)->count();
            if ($count > 0) {
                Blog_like::where('blog_id', $blog_id)->where('user_id', $user_id)->delete();
                $count = $count - 1;
                return $count;
            } else {
                $blogLike = new Blog_like();
                $blogLike->blog_id = $blog_id;
                $blogLike->user_id = $user_id;
                $blogLike->save();
                $count = $count + 1;
                return $count;
            }

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function blog_comment(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $comment = $request->comment;
            $blog_id = $request->blog_id;
            $comment_count = Blog_comment::where('blog_id', $blog_id)->where('user_id', $user_id)->count();
            $blogComment = new Blog_comment();
            $blogComment->blog_id = $blog_id;
            $blogComment->user_id = $user_id;
            $blogComment->comment = $comment;
            $blogComment->save();
            return $comment_count;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function blog_detail($id)
    {
        try{
            $blog = Blog::with('blog_like')->with('blog_comment')->where('id',$id)->first()->toArray();

            return view('blogs.detail', compact('blog'));
            
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

}
