<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubmitFormRequest;
use App\Http\Requests\UpdateSubmitFormRequest;
use App\Repositories\SubmitFormRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\SubmitForm;

class SubmitFormController extends AppBaseController
{
    /** @var  SubmitFormRepository */
    private $submitFormRepository;

    public function __construct(SubmitFormRepository $submitFormRepo)
    {
        $this->submitFormRepository = $submitFormRepo;
    }

    /**
     * Display a listing of the SubmitForm.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->submitFormRepository->pushCriteria(new RequestCriteria($request));
        // $submitForms = $this->submitFormRepository->all();
        $submitForms = SubmitForm::orderBy('created_at', 'desc')->paginate(15);

        return view('submit_forms.index')
            ->with('submitForms', $submitForms);
    }

    /**
     * Show the form for creating a new SubmitForm.
     *
     * @return Response
     */
    public function create()
    {
        return view('submit_forms.create');
    }

    /**
     * Store a newly created SubmitForm in storage.
     *
     * @param CreateSubmitFormRequest $request
     *
     * @return Response
     */
    public function store(CreateSubmitFormRequest $request)
    {
        $input = $request->all();

        $submitForm = $this->submitFormRepository->create($input);

        Flash::success('Submit Form saved successfully.');

        return redirect(route('submitForms.index'));
    }

    /**
     * Display the specified SubmitForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $submitForm = $this->submitFormRepository->findWithoutFail($id);

        if (empty($submitForm)) {
            Flash::error('Submit Form not found');

            return redirect(route('submitForms.index'));
        }

        return view('submit_forms.show')->with('submitForm', $submitForm);
    }

    /**
     * Show the form for editing the specified SubmitForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $submitForm = $this->submitFormRepository->findWithoutFail($id);

        if (empty($submitForm)) {
            Flash::error('Submit Form not found');

            return redirect(route('submitForms.index'));
        }

        return view('submit_forms.edit')->with('submitForm', $submitForm);
    }

    /**
     * Update the specified SubmitForm in storage.
     *
     * @param  int              $id
     * @param UpdateSubmitFormRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubmitFormRequest $request)
    {
        $submitForm = $this->submitFormRepository->findWithoutFail($id);

        if (empty($submitForm)) {
            Flash::error('Submit Form not found');

            return redirect(route('submitForms.index'));
        }

        $submitForm = $this->submitFormRepository->update($request->all(), $id);

        Flash::success('Submit Form updated successfully.');

        return redirect(route('submitForms.index'));
    }

    /**
     * Remove the specified SubmitForm from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $submitForm = $this->submitFormRepository->findWithoutFail($id);

        if (empty($submitForm)) {
            Flash::error('Submit Form not found');

            return redirect(route('submitForms.index'));
        }

        $this->submitFormRepository->delete($id);

        Flash::success('Submit Form deleted successfully.');

        return redirect(route('submitForms.index'));
    }
}
