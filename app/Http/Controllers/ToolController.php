<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Repositories\ToolRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\ToolCat;

class ToolController extends AppBaseController
{
    /** @var  ToolRepository */
    private $toolRepository;

    public function __construct(ToolRepository $toolRepo)
    {
        $this->toolRepository = $toolRepo;
    }

    /**
     * Display a listing of the Tool.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->toolRepository->pushCriteria(new RequestCriteria($request));
        $tools = $this->toolRepository->orderBy('created_at','desc')->paginate(15);

        return view('tools.index')
            ->with('tools', $tools);
    }

    /**
     * Show the form for creating a new Tool.
     *
     * @return Response
     */
    public function create()
    {
        $toolCats = ToolCat::all();
        $model_required =  \Zcjy::modelRequiredParam($this->toolRepository->model());
        return view('tools.create', compact('toolCats','model_required'));
    }

    /**
     * Store a newly created Tool in storage.
     *
     * @param CreateToolRequest $request
     *
     * @return Response
     */
    public function store(CreateToolRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        $tool = $this->toolRepository->create($input);

        Flash::success('Tool saved successfully.');

        return redirect(route('tools.index'));
    }

    /**
     * Display the specified Tool.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tool = $this->toolRepository->findWithoutFail($id);

        if (empty($tool)) {
            Flash::error('Tool not found');

            return redirect(route('tools.index'));
        }

        return view('tools.show')->with('tool', $tool);
    }

    /**
     * Show the form for editing the specified Tool.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tool = $this->toolRepository->findWithoutFail($id);

        if (empty($tool)) {
            Flash::error('Tool not found');

            return redirect(route('tools.index'));
        }

        $toolCats = ToolCat::all();
        $model_required =  \Zcjy::modelRequiredParam($this->toolRepository->model());
        return view('tools.edit')
        ->with('tool', $tool)
        ->with('toolCats', $toolCats)
        ->with('model_required',$model_required);
    }

    /**
     * Update the specified Tool in storage.
     *
     * @param  int              $id
     * @param UpdateToolRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateToolRequest $request)
    {
        $tool = $this->toolRepository->findWithoutFail($id);

        if (empty($tool)) {
            Flash::error('Tool not found');

            return redirect(route('tools.index'));
        }

        $input = $request->all();

        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        $tool = $this->toolRepository->update($input, $id);

        Flash::success('Tool updated successfully.');

        return redirect(route('tools.index'));
    }

    /**
     * Remove the specified Tool from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tool = $this->toolRepository->findWithoutFail($id);

        if (empty($tool)) {
            Flash::error('Tool not found');

            return redirect(route('tools.index'));
        }

        $this->toolRepository->delete($id);

        Flash::success('Tool deleted successfully.');

        return redirect(route('tools.index'));
    }
}
