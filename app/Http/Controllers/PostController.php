<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Lấy tất cả dữ liệu từ bảng 'posts'
        $posts = Post::all();

        // Truyền dữ liệu sang view 'posts.index'
        return view('posts.index', compact('posts'));
    }
}