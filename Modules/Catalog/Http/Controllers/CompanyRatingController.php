<?php

namespace Modules\Catalog\Http\Controllers;

use Modules\Catalog\DataTables\CompanyRatingDataTable;
use Modules\Catalog\Http\Requests;
use Modules\Catalog\Http\Requests\CreateCompanyRatingRequest;
use Modules\Catalog\Http\Requests\UpdateCompanyRatingRequest;
use Modules\Catalog\Repositories\CompanyRatingRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CompanyRatingController extends AppBaseController
{
    /** @var  CompanyRatingRepository */
    private $companyRatingRepository;

    public function __construct(CompanyRatingRepository $companyRatingRepo)
    {
        $this->companyRatingRepository = $companyRatingRepo;
    }

    /**
     * Display a listing of the CompanyRating.
     *
     * @param CompanyRatingDataTable $companyRatingDataTable
     * @return Response
     */
    public function index(CompanyRatingDataTable $companyRatingDataTable)
    {
        return $companyRatingDataTable->render('catalog::company_ratings.index');
    }

    /**
     * Show the form for creating a new CompanyRating.
     *
     * @return Response
     */
    public function create()
    {
        return view('catalog::company_ratings.create');
    }

    /**
     * Store a newly created CompanyRating in storage.
     *
     * @param CreateCompanyRatingRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyRatingRequest $request)
    {
        $input = $request->all();

        $companyRating = $this->companyRatingRepository->create($input);

        //recalculate rating for company
        $this->companyRatingRepository->recalculate($companyRating->company_id);

        Flash::success('Company Rating saved successfully.');

        return redirect(route('catalog.companyRatings.index'));
    }

    /**
     * Display the specified CompanyRating.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $companyRating = $this->companyRatingRepository->findWithoutFail($id);

        if (empty($companyRating)) {
            Flash::error('Company Rating not found');

            return redirect(route('catalog.companyRatings.index'));
        }

        return view('catalog::company_ratings.show')->with('companyRating', $companyRating);
    }

    /**
     * Show the form for editing the specified CompanyRating.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $companyRating = $this->companyRatingRepository->findWithoutFail($id);

        if (empty($companyRating)) {
            Flash::error('Company Rating not found');

            return redirect(route('catalog.companyRatings.index'));
        }

        return view('catalog::company_ratings.edit')->with('companyRating', $companyRating);
    }

    /**
     * Update the specified CompanyRating in storage.
     *
     * @param  int              $id
     * @param UpdateCompanyRatingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyRatingRequest $request)
    {
        $companyRating = $this->companyRatingRepository->findWithoutFail($id);

        if (empty($companyRating)) {
            Flash::error('Company Rating not found');

            return redirect(route('catalog.companyRatings.index'));
        }

        $companyRating = $this->companyRatingRepository->update($request->all(), $id);

        Flash::success('Company Rating updated successfully.');

        return redirect(route('catalog.companyRatings.index'));
    }

    /**
     * Remove the specified CompanyRating from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $companyRating = $this->companyRatingRepository->findWithoutFail($id);

        if (empty($companyRating)) {
            Flash::error('Company Rating not found');

            return redirect(route('catalog.companyRatings.index'));
        }

        $this->companyRatingRepository->delete($id);

        Flash::success('Company Rating deleted successfully.');

        return redirect(route('catalog.companyRatings.index'));
    }
}
