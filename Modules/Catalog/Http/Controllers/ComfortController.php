<?php

namespace Modules\Catalog\Http\Controllers;

use Modules\Catalog\DataTables\ComfortDataTable;
use Modules\Catalog\Http\Requests;
use Modules\Catalog\Http\Requests\CreateComfortRequest;
use Modules\Catalog\Http\Requests\UpdateComfortRequest;
use Modules\Catalog\Repositories\ComfortRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ComfortController extends AppBaseController
{
    /** @var  ComfortRepository */
    private $comfortRepository;

    public function __construct(ComfortRepository $comfortRepo)
    {
        $this->comfortRepository = $comfortRepo;
    }

    /**
     * Display a listing of the Comfort.
     *
     * @param ComfortDataTable $comfortDataTable
     * @return Response
     */
    public function index(ComfortDataTable $comfortDataTable)
    {
        return $comfortDataTable->render('catalog::comforts.index');
    }

    /**
     * Show the form for creating a new Comfort.
     *
     * @return Response
     */
    public function create()
    {
        return view('catalog::comforts.create');
    }

    /**
     * Store a newly created Comfort in storage.
     *
     * @param CreateComfortRequest $request
     *
     * @return Response
     */
    public function store(CreateComfortRequest $request)
    {
        $input = $request->all();

        $comfort = $this->comfortRepository->create($input);

        Flash::success('Comfort saved successfully.');

        return redirect(route('catalog.comforts.index'));
    }

    /**
     * Display the specified Comfort.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $comfort = $this->comfortRepository->findWithoutFail($id);

        if (empty($comfort)) {
            Flash::error('Comfort not found');

            return redirect(route('catalog.comforts.index'));
        }

        return view('catalog::comforts.show')->with('comfort', $comfort);
    }

    /**
     * Show the form for editing the specified Comfort.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $comfort = $this->comfortRepository->findWithoutFail($id);

        if (empty($comfort)) {
            Flash::error('Comfort not found');

            return redirect(route('catalog.comforts.index'));
        }

        return view('catalog::comforts.edit')->with('comfort', $comfort);
    }

    /**
     * Update the specified Comfort in storage.
     *
     * @param  int              $id
     * @param UpdateComfortRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComfortRequest $request)
    {
        $comfort = $this->comfortRepository->findWithoutFail($id);

        if (empty($comfort)) {
            Flash::error('Comfort not found');

            return redirect(route('catalog.comforts.index'));
        }

        $comfort = $this->comfortRepository->update($request->all(), $id);

        Flash::success('Comfort updated successfully.');

        return redirect(route('catalog.comforts.index'));
    }

    /**
     * Remove the specified Comfort from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $comfort = $this->comfortRepository->findWithoutFail($id);

        if (empty($comfort)) {
            Flash::error('Comfort not found');

            return redirect(route('catalog.comforts.index'));
        }

        $this->comfortRepository->delete($id);

        Flash::success('Comfort deleted successfully.');

        return redirect(route('catalog.comforts.index'));
    }
}
