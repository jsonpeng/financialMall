<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserPostRequest;
use App\Http\Requests\UpdateUserPostRequest;
use App\Repositories\UserPostRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserPostController extends AppBaseController
{
    /** @var  UserPostRepository */
    private $userPostRepository;

    public function __construct(UserPostRepository $userPostRepo)
    {
        $this->userPostRepository = $userPostRepo;
    }

    /**
     * Display a listing of the UserPost.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userPostRepository->pushCriteria(new RequestCriteria($request));
        $userPosts = $this->userPostRepository->all();

        return view('user_posts.index')
            ->with('userPosts', $userPosts);
    }

    /**
     * Show the form for creating a new UserPost.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_posts.create');
    }

    /**
     * Store a newly created UserPost in storage.
     *
     * @param CreateUserPostRequest $request
     *
     * @return Response
     */
    public function store(CreateUserPostRequest $request)
    {
        $input = $request->all();

        $userPost = $this->userPostRepository->create($input);

        Flash::success('User Post saved successfully.');

        return redirect(route('userPosts.index'));
    }

    /**
     * Display the specified UserPost.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userPost = $this->userPostRepository->findWithoutFail($id);

        if (empty($userPost)) {
            Flash::error('User Post not found');

            return redirect(route('userPosts.index'));
        }

        return view('user_posts.show')->with('userPost', $userPost);
    }

    /**
     * Show the form for editing the specified UserPost.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userPost = $this->userPostRepository->findWithoutFail($id);

        if (empty($userPost)) {
            Flash::error('User Post not found');

            return redirect(route('userPosts.index'));
        }

        return view('user_posts.edit')->with('userPost', $userPost);
    }

    /**
     * Update the specified UserPost in storage.
     *
     * @param  int              $id
     * @param UpdateUserPostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserPostRequest $request)
    {
        $userPost = $this->userPostRepository->findWithoutFail($id);

        if (empty($userPost)) {
            Flash::error('User Post not found');

            return redirect(route('userPosts.index'));
        }

        $userPost = $this->userPostRepository->update($request->all(), $id);

        Flash::success('User Post updated successfully.');

        return redirect(route('userPosts.index'));
    }

    /**
     * Remove the specified UserPost from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userPost = $this->userPostRepository->findWithoutFail($id);

        if (empty($userPost)) {
            Flash::error('User Post not found');

            return redirect(route('userPosts.index'));
        }

        $this->userPostRepository->delete($id);

        Flash::success('User Post deleted successfully.');

        return redirect(route('userPosts.index'));
    }
}
