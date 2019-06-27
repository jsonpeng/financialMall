<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use App\Repositories\PostCategoryRepository as CategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\Auth;

use App\Models\Post;

class PostController extends AppBaseController
{
    /** @var  PostRepository */
    private $postRepository;
    private $categoryRepository;

    public function __construct(PostRepository $postRepo, CategoryRepository $categoryRepo)
    {
        $this->postRepository = $postRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Post.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            session(['page' => $request->input('page')]);
        } else {
            session(['page' => 1]);
        }

        $input  = $request->all();
        $categories = $this->categoryRepository->all();

        $posts = Post::orderBy('created_at', 'desc');

        if (array_key_exists('name', $input) && $input['name'] != "") {
            $posts->where('name', 'like', '%'.$input['name'].'%');
        }
        if (array_key_exists('category', $input) && $input['category'] != "全部") {
            $posts->where('category_id', $input['category']);
        }

        $posts = $posts->paginate(15);

        //dd($posts);

        return view('posts.index')
            ->with('posts', $posts)->with('categories', $categories)->withInput($input);
    }

    /**
     * Show the form for creating a new Post.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        return view('posts.create')
        ->with('categories', $categories)
        ->with('model_required',\Zcjy::modelRequiredParam($this->postRepository->model()));
    }

    /**
     * Store a newly created Post in storage.
     *
     * @param CreatePostRequest $request
     *
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        $input['user_id'] = auth('admin')->user()->id;

        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 100000);
        }

        $post = $this->postRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('文章不存在');

            return redirect(route('posts.index'));
        }

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('文章不存在');

            return redirect(route('posts.index'));
        }
        $categories = $this->categoryRepository->all();


        return view('posts.edit')
        ->with('post', $post)
        ->with('categories', $categories)
        ->with('model_required',\Zcjy::modelRequiredParam($this->postRepository->model()));
    }

    /**
     * Update the specified Post in storage.
     *
     * @param  int              $id
     * @param UpdatePostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostRequest $request)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('文章不存在');

            return redirect(route('posts.index'));
        }

        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 100000);
        }

        $post = $this->postRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(route('posts.index', ['page' => session('page')]));
    }

    /**
     * Remove the specified Post from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('文章不存在');

            return redirect(route('posts.index'));
        }

        $this->postRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('posts.index', ['page' => session('page')]));
    }
}
