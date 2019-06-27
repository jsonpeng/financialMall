<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAmazingManPostRequest;
use App\Http\Requests\UpdateAmazingManPostRequest;
use App\Repositories\AmazingManPostRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AmazingManPostController extends AppBaseController
{
    /** @var  AmazingManPostRepository */
    private $amazingManPostRepository;

    public function __construct(AmazingManPostRepository $amazingManPostRepo)
    {
        $this->amazingManPostRepository = $amazingManPostRepo;
    }

    /**
     * Display a listing of the AmazingManPost.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->amazingManPostRepository->pushCriteria(new RequestCriteria($request));
        $amazingManPosts = $this->amazingManPostRepository->all();

        return view('amazing_man_posts.index')
            ->with('amazingManPosts', $amazingManPosts);
    }

    /**
     * Show the form for creating a new AmazingManPost.
     *
     * @return Response
     */
    public function create()
    {
        return view('amazing_man_posts.create');
    }

    /**
     * Store a newly created AmazingManPost in storage.
     *
     * @param CreateAmazingManPostRequest $request
     *
     * @return Response
     */
    public function store(CreateAmazingManPostRequest $request)
    {
        $input = $request->all();

        $amazingManPost = $this->amazingManPostRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('amazingManPosts.index'));
    }

    /**
     * Display the specified AmazingManPost.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $amazingManPost = $this->amazingManPostRepository->findWithoutFail($id);

        if (empty($amazingManPost)) {
            Flash::error('Amazing Man Post not found');

            return redirect(route('amazingManPosts.index'));
        }

        return view('amazing_man_posts.show')->with('amazingManPost', $amazingManPost);
    }

    /**
     * Show the form for editing the specified AmazingManPost.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $amazingManPost = $this->amazingManPostRepository->findWithoutFail($id);

        if (empty($amazingManPost)) {
            Flash::error('Amazing Man Post not found');

            return redirect(route('amazingManPosts.index'));
        }

        return view('amazing_man_posts.edit')->with('amazingManPost', $amazingManPost);
    }

    /**
     * Update the specified AmazingManPost in storage.
     *
     * @param  int              $id
     * @param UpdateAmazingManPostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAmazingManPostRequest $request)
    {
        $amazingManPost = $this->amazingManPostRepository->findWithoutFail($id);

        if (empty($amazingManPost)) {
            Flash::error('Amazing Man Post not found');

            return redirect(route('amazingManPosts.index'));
        }

        $amazingManPost = $this->amazingManPostRepository->update($request->all(), $id);

        Flash::success('Amazing Man Post updated successfully.');

        return redirect(route('amazingManPosts.index'));
    }

    /**
     * Remove the specified AmazingManPost from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $amazingManPost = $this->amazingManPostRepository->findWithoutFail($id);

        if (empty($amazingManPost)) {
            Flash::error('Amazing Man Post not found');

            return redirect(route('amazingManPosts.index'));
        }

        $this->amazingManPostRepository->delete($id);

        Flash::success('Amazing Man Post deleted successfully.');

        return redirect(route('amazingManPosts.index'));
    }
}
