<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTopicsRequest;
use App\Http\Requests\UpdateTopicsRequest;
use App\Repositories\TopicsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TopicsController extends AppBaseController
{
    /** @var  TopicsRepository */
    private $topicsRepository;

    public function __construct(TopicsRepository $topicsRepo)
    {
        $this->topicsRepository = $topicsRepo;
    }

    /**
     * Display a listing of the Topics.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request,$paper_id)
    {
        $paper = app('commonRepo')->paperRepo()->findWithoutFail($paper_id);

        if(empty($paper)){
            return redirect(route('paperLists.index'));
        }

        $this->topicsRepository->pushCriteria(new RequestCriteria($request));

        $topics = app('commonRepo')->topicsRepo()->paperTopicsFirstOrAll($paper->id,false,0,100);

        return view('topics.index')
            ->with('topics', $topics)
            ->with('paper',$paper);
    }

    /**
     * Show the form for creating a new Topics.
     *
     * @return Response
     */
    public function create($paper_id)
    {
        $paper = app('commonRepo')->paperRepo()->findWithoutFail($paper_id);
      

        if(empty($paper)){
            return redirect(route('paperLists.index'));
        }

        $topic = app('commonRepo')->topicsRepo()->paperTopicsFirstOrAll($paper_id);
        if(empty($topic)){
            $topic = 1;
        }
        else{
            $topic = $topic->sort + 1;
        }

        return view('topics.create')
          ->with('paper',$paper)
          ->with('topic',$topic);
    }

    /**
     * Store a newly created Topics in storage.
     *
     * @param CreateTopicsRequest $request
     *
     * @return Response
     */
    public function store(CreateTopicsRequest $request,$paper_id)
    {
        $input = $request->all();

        $topics = $this->topicsRepository->create($input);

        Flash::success('添加试题成功.');

        return redirect(route('topics.index',$paper_id));
    }

    /**
     * Display the specified Topics.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($paper_id,$id)
    {
        $topics = $this->topicsRepository->findWithoutFail($id);

        if (empty($topics)) {
            Flash::error('Topics not found');

            return redirect(route('topics.index',$paper_id));
        }

        return view('topics.show')->with('topics', $topics);
    }

    /**
     * Show the form for editing the specified Topics.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($paper_id,$id)
    {
        $topics = $this->topicsRepository->findWithoutFail($id);

        if (empty($topics)) {
            Flash::error('Topics not found');

            return redirect(route('topics.index',$paper_id));
        }

        $paper = app('commonRepo')->paperRepo()->findWithoutFail($paper_id);

        if(empty($paper)){
            return redirect(route('paperLists.index'));
        }
        $topic = $paper->sort;
        return view('topics.edit')
        ->with('topics', $topics)
        ->with('paper',$paper)
        ->with('topic',$topic);
    }

    /**
     * Update the specified Topics in storage.
     *
     * @param  int              $id
     * @param UpdateTopicsRequest $request
     *
     * @return Response
     */
    public function update($paper_id,$id, UpdateTopicsRequest $request)
    {
        $topics = $this->topicsRepository->findWithoutFail($id);

        if (empty($topics)) {
            Flash::error('Topics not found');

            return redirect(route('topics.index',$paper_id));
        }

        $topics = $this->topicsRepository->update($request->all(), $id);

        Flash::success('试题保存成功.');

        return redirect(route('topics.index',$paper_id));
    }

    /**
     * Remove the specified Topics from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($paper_id,$id)
    {
        $topics = $this->topicsRepository->findWithoutFail($id);

        if (empty($topics)) {
            Flash::error('Topics not found');

            return redirect(route('topics.index',$paper_id));
        }

        $this->topicsRepository->delete($id);

        Flash::success('试题删除成功.');

        return redirect(route('topics.index',$paper_id));
    }
}
