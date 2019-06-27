<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Post;
use Flash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use App\Repositories\PostRepository;
use App\Repositories\OldProductRepository as CategoryRepository;

class CategoryController extends Controller
{
    private $postRepository;
    private $categoryRepository;

    public function __construct(PostRepository $postRepo, CategoryRepository $categoryRepo)
    {
        $this->postRepository = $postRepo;
        $this->categoryRepository = $categoryRepo;
    }

    public function index(Request $request, $id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            return redirect('/');
        }
        $posts = Post::where('category_id', $id)->orderBy('created_at', 'desc')->paginate(15);
        return view('front.category.index')
            ->with('category', $category)
            ->with('posts', $posts);
    }

    public function post(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update(['view' => $post->view + 1]);
        return view('front.category.post')
            ->with('post', $post);
    }
}
