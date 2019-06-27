<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\PostCategoryRepository as CategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

// use App\Models\PostCategory;
use App\Models\Post;
use App\Models\PostCategory;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $categories = $this->categoryRepository->all();
        //$categories = PostCategory::orderBy('created_at', 'desc')->get();

        return view('categories.index')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('categories.create')->with('model_required',\Zcjy::modelRequiredParam(PostCategory::class));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $category = PostCategory::create($input);

        Flash::success('保存成功');

        return redirect(route('categoriescat.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = PostCategory::find($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('categoriescat.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = PostCategory::find($id);

        if (empty($category)) 
        {
            Flash::error('信息不存在');

            return redirect(route('categoriescat.index'));
        }

        return view('categories.edit')
        ->with('category', $category)
        ->with('model_required',\Zcjy::modelRequiredParam(PostCategory::class));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = PostCategory::find($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('categoriescat.index'));
        }

        $input = $request->all();

        if (!array_key_exists('shoufei', $input)) {
            $input['shoufei'] = 0;
        }

        $category->update($input);

        Flash::success('更新成功');

        return redirect(route('categoriescat.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = PostCategory::find($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('categoriescat.index'));
        }

        Post::where('category_id', $id)->delete();

        $category->delete($id);

        Flash::success('删除成功');

        return redirect(route('categoriescat.index'));
    }
}
