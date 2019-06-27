<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSelectionsTopicRequest;
use App\Http\Requests\UpdateSelectionsTopicRequest;
use App\Repositories\SelectionsTopicRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Config;

class SelectionsTopicController extends AppBaseController
{
    /** @var  SelectionsTopicRepository */
    private $selectionsTopicRepository;

    public function __construct(SelectionsTopicRepository $selectionsTopicRepo)
    {
        $this->selectionsTopicRepository = $selectionsTopicRepo;
    }

    /**
     * Display a listing of the SelectionsTopic.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request,$topic_id)
    {
        $topic = app('commonRepo')->topicsRepo()->findWithoutFail($topic_id);

        if(empty($topic)){
             return redirect(route('paperLists.index'));
        }

        $this->selectionsTopicRepository->pushCriteria(new RequestCriteria($request));
        
        $selectionsTopics = $this->selectionsTopicRepository->topicSelects($topic->id);

        return view('selections_topics.index')
            ->with('selectionsTopics', $selectionsTopics)
            ->with('topic',$topic);
    }

    /**
     * Show the form for creating a new SelectionsTopic.
     *
     * @return Response
     */
    public function create($topic_id)
    {
        $topic = app('commonRepo')->topicsRepo()->findWithoutFail($topic_id);

        if(empty($topic)){
             return redirect(route('paperLists.index'));
        }

        $selects = Config::get('paper.select');

        $topic_select = $this->selectionsTopicRepository->topicSelects($topic->id);

        #处理选项
        foreach ($selects as $key1 => $val1) {
            foreach ($topic_select as $key2 => $val2) {
                if($val2->type == $val1){
                    unset($selects[$key1]);
                }
            }
        }


        return view('selections_topics.create')
            ->with('topic',$topic)
            ->with('selects',$selects);
    }

    /**
     * Store a newly created SelectionsTopic in storage.
     *
     * @param CreateSelectionsTopicRequest $request
     *
     * @return Response
     */
    public function store(CreateSelectionsTopicRequest $request,$topic_id)
    {
        $input = $request->all();

        $selectionsTopic = $this->selectionsTopicRepository->create($input);

        Flash::success('选项添加成功.');

        return redirect(route('selectionsTopics.index',$topic_id));
    }

    /**
     * Display the specified SelectionsTopic.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $selectionsTopic = $this->selectionsTopicRepository->findWithoutFail($id);

        if (empty($selectionsTopic)) {
            Flash::error('Selections Topic not found');

            return redirect(route('selectionsTopics.index',$topic_id));
        }

        return view('selections_topics.show')->with('selectionsTopic', $selectionsTopic);
    }

    /**
     * Show the form for editing the specified SelectionsTopic.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($topic_id,$id)
    {
        $selectionsTopic = $this->selectionsTopicRepository->findWithoutFail($id);

        if (empty($selectionsTopic)) {
            Flash::error('Selections Topic not found');

            return redirect(route('selectionsTopics.index',$topic_id));
        }
        $topic = app('commonRepo')->topicsRepo()->findWithoutFail($topic_id);

        if(empty($topic)){
             return redirect(route('paperLists.index'));
        }
        $selects = Config::get('paper.select');

        $topic_select = $this->selectionsTopicRepository->topicSelects($topic->id);

        #处理选项
        foreach ($selects as $key1 => $val1) {
            foreach ($topic_select as $key2 => $val2) {
                if($val2->type == $val1){
                    unset($selects[$key1]);
                }
            }
        }
        #添加当前选项自己
        array_push($selects,$selectionsTopic->type);

        return view('selections_topics.edit')
        ->with('selectionsTopic', $selectionsTopic)
        ->with('topic',$topic)
        ->with('selects',$selects);
    }

    /**
     * Update the specified SelectionsTopic in storage.
     *
     * @param  int              $id
     * @param UpdateSelectionsTopicRequest $request
     *
     * @return Response
     */
    public function update($topic_id,$id, UpdateSelectionsTopicRequest $request)
    {

        $selectionsTopic = $this->selectionsTopicRepository->findWithoutFail($id);

        if (empty($selectionsTopic)) {
            Flash::error('Selections Topic not found');

            return redirect(route('selectionsTopics.index',$topic_id));
        }

        $selectionsTopic = $this->selectionsTopicRepository->update($request->all(), $id);

        Flash::success('选项更新成功.');

        return redirect(route('selectionsTopics.index',$topic_id));
    }

    /**
     * Remove the specified SelectionsTopic from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($topic_id,$id)
    {
        $selectionsTopic = $this->selectionsTopicRepository->findWithoutFail($id);

        if (empty($selectionsTopic)) {
            Flash::error('Selections Topic not found');

            return redirect(route('selectionsTopics.index',$topic_id));
        }

        $this->selectionsTopicRepository->delete($id);

        Flash::success('选项删除成功.');

        return redirect(route('selectionsTopics.index',$topic_id));
    }
}
