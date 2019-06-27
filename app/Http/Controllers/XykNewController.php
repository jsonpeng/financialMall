<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateXykNewRequest;
use App\Http\Requests\UpdateXykNewRequest;
use App\Repositories\XykNewRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class XykNewController extends AppBaseController
{
    /** @var  XykNewRepository */
    private $xykNewRepository;

    public function __construct(XykNewRepository $xykNewRepo)
    {
        $this->xykNewRepository = $xykNewRepo;
    }

    /**
     * Display a listing of the XykNew.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->xykNewRepository->pushCriteria(new RequestCriteria($request));
        $xykNews = $this->xykNewRepository->all();

        return view('xyk_news.index')
            ->with('xykNews', $xykNews);
    }

    /**
     * Show the form for creating a new XykNew.
     *
     * @return Response
     */
    public function create()
    {
        return view('xyk_news.create');
    }

    /**
     * Store a newly created XykNew in storage.
     *
     * @param CreateXykNewRequest $request
     *
     * @return Response
     */
    public function store(CreateXykNewRequest $request)
    {
        $input = $request->all();

        if (empty($input['applier'] )) {
             $input['applier'] = random_int(100000, 200000);
        }

        if (!array_key_exists('hot', $input)) {
            $input['hot'] = 0;
        }

        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        $xykNew = $this->xykNewRepository->create($input);

        Flash::success('Xyk New saved successfully.');

        return redirect(route('xykNews.index'));
    }

    /**
     * Display the specified XykNew.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $xykNew = $this->xykNewRepository->findWithoutFail($id);

        if (empty($xykNew)) {
            Flash::error('Xyk New not found');

            return redirect(route('xykNews.index'));
        }

        return view('xyk_news.show')->with('xykNew', $xykNew);
    }

    /**
     * Show the form for editing the specified XykNew.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $xykNew = $this->xykNewRepository->findWithoutFail($id);

        if (empty($xykNew)) {
            Flash::error('Xyk New not found');

            return redirect(route('xykNews.index'));
        }

        return view('xyk_news.edit')->with('xykNew', $xykNew);
    }

    /**
     * Update the specified XykNew in storage.
     *
     * @param  int              $id
     * @param UpdateXykNewRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateXykNewRequest $request)
    {
        $xykNew = $this->xykNewRepository->findWithoutFail($id);

        if (empty($xykNew)) {
            Flash::error('Xyk New not found');

            return redirect(route('xykNews.index'));
        }

        $input = $request->all();

        if (!array_key_exists('hot', $input)) {
            $input['hot'] = 0;
        }

        if (array_key_exists('link', $input) && $input['link'] != '') {
            if(!preg_match("/^(http:\/\/|https:\/\/).*$/", $input['link'])){
                $input['link'] = 'http://'.$input['link'];
            }
        }

        $xykNew = $this->xykNewRepository->update($input, $id);

        Flash::success('Xyk New updated successfully.');

        return redirect(route('xykNews.index'));
    }

    /**
     * Remove the specified XykNew from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $xykNew = $this->xykNewRepository->findWithoutFail($id);

        if (empty($xykNew)) {
            Flash::error('Xyk New not found');

            return redirect(route('xykNews.index'));
        }

        $this->xykNewRepository->delete($id);

        Flash::success('Xyk New deleted successfully.');

        return redirect(route('xykNews.index'));
    }
}
