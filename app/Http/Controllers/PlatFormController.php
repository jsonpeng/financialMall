<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlatFormRequest;
use App\Http\Requests\UpdatePlatFormRequest;
use App\Repositories\PlatFormRepository;
use App\Repositories\PlatFormCatRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\PlatForm;

class PlatFormController extends AppBaseController
{
    /** @var  PlatFormRepository */
    private $platFormRepository;
    private $platFormCatRepository;

    public function __construct(PlatFormRepository $platFormRepo, PlatFormCatRepository $platFormCatRepo)
    {
        $this->platFormRepository = $platFormRepo;
        $this->platFormCatRepository = $platFormCatRepo;
    }

    /**
     * Display a listing of the PlatForm.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        session(['productIndexUrl' => $request->fullUrl()]);

        if ($request->has('page')) {
            session(['page' => $request->input('page')]);
        } else {
            session(['page' => 1]);
        }
        
        $input  = $request->all();
        $categories = $this->platFormCatRepository->all();

        $type = '1';
        if (array_key_exists('order', $input)) {
            $type = $input['order'];
        }

        $platForms = [];
        if ($type == '1') {
            $platForms = PlatForm::orderBy('sort', 'desc')->orderBy('created_at', 'desc');
        }
        else if ($type == '2') {
            $platForms = PlatForm::orderBy('hot', 'desc')->orderBy('sort', 'desc')->orderBy('created_at');
        }
        else if ($type == '3') {
            $platForms = PlatForm::orderBy('star', 'desc')->orderBy('sort', 'desc')->orderBy('created_at');
        }else{
            $platForms = PlatForm::orderBy('sort', 'desc')->orderBy('created_at', 'desc');
        }


        //$platForms = PlatForm::orderBy('hot', 'desc')->orderBy('created_at', 'desc');
        if (array_key_exists('name', $input) && $input['name'] != "") {
            $platForms->where('name', 'like', '%'.$input['name'].'%');
        }
        if (array_key_exists('category', $input) && $input['category'] != "全部") {
            $platForms->where('plat_form_cat_id', $input['category']);
        }

        $platForms = $platForms->paginate(15);

        return view('plat_forms.index')
            ->with('platForms', $platForms)->with('categories', $categories)->withInput($input);
    }

    /**
     * Show the form for creating a new PlatForm.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->platFormCatRepository->all();
        return view('plat_forms.create')
        ->with('categories', $categories)
        ->with('model_required',\Zcjy::modelRequiredParam($this->platFormRepository->model()));
    }

    /**
     * Store a newly created PlatForm in storage.
     *
     * @param CreatePlatFormRequest $request
     *
     * @return Response
     */
    public function store(CreatePlatFormRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 20000);
        }

        $input['brief']= preg_replace("/\n|\r\n/", "<br/>", $input['brief']); 
        $input['tiaojian']= preg_replace("/\n|\r\n/", "<br/>", $input['tiaojian']);
        $input['cailiao']= preg_replace("/\n|\r\n/", "<br/>", $input['cailiao']);

        $platForm = $this->platFormRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('platForms.index'));
    }

    /**
     * Display the specified PlatForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $platForm = $this->platFormRepository->findWithoutFail($id);

        if (empty($platForm)) {
            Flash::error('平台不存在');

            return redirect(route('platForms.index'));
        }

        return view('plat_forms.show')->with('platForm', $platForm);
    }

    /**
     * Show the form for editing the specified PlatForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $platForm = $this->platFormRepository->findWithoutFail($id);

        if (empty($platForm)) {
            Flash::error('平台不存在');

            return redirect(route('platForms.index'));
        }

        $platForm->brief = str_replace("<br/>", "\n", $platForm->brief);
        $platForm->tiaojian = str_replace("<br/>", "\n", $platForm->tiaojian);
        $platForm->cailiao = str_replace("<br/>", "\n", $platForm->cailiao);

        $categories = $this->platFormCatRepository->all();

        return view('plat_forms.edit')
        ->with('platForm', $platForm)
        ->with('categories', $categories)
        ->with('model_required',\Zcjy::modelRequiredParam($this->platFormRepository->model()));
    }

    /**
     * Update the specified PlatForm in storage.
     *
     * @param  int              $id
     * @param UpdatePlatFormRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlatFormRequest $request)
    {
        $platForm = $this->platFormRepository->findWithoutFail($id);

        if (empty($platForm)) {
            Flash::error('平台不存在');

            return redirect(route('platForms.index'));
        }

        $input = $request->all();
        if (empty($input['view'] )) {
             $input['view'] = random_int(10000, 20000);
        }
        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }
        if (!array_key_exists('hot', $input)) {
            $input['hot'] = 0;
        }

        $input['brief']= preg_replace("/\n|\r\n/", "<br/>", $input['brief']);
        $input['tiaojian']= preg_replace("/\n|\r\n/", "<br/>", $input['tiaojian']);
        $input['cailiao']= preg_replace("/\n|\r\n/", "<br/>", $input['cailiao']);

        $platForm = $this->platFormRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(session('productIndexUrl'));

        //return redirect(route('platForms.index', ['page' => session('page')]));
    }

    /**
     * Remove the specified PlatForm from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $platForm = $this->platFormRepository->findWithoutFail($id);

        if (empty($platForm)) {
            Flash::error('平台不存在');

            return redirect(route('platForms.index'));
        }

        $this->platFormRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('platForms.index', ['page' => session('page')]));
    }
}
