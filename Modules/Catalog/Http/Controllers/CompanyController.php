<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Modules\Catalog\DataTables\CompanyDataTable;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Http\Requests;
use Modules\Catalog\Http\Requests\CreateCompanyRequest;
use Modules\Catalog\Http\Requests\UpdateCompanyRequest;
use Modules\Catalog\Repositories\CompanyRepository;
use Modules\Catalog\Repositories\CityRepository;
use Modules\Catalog\Repositories\ComfortRepository;
use Modules\Catalog\Repositories\CompanyDetailRepository;
use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Repositories\ServiceRepository;
use Modules\Catalog\Repositories\CompanyRatingRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CompanyController extends AppBaseController
{
    /** @var  CompanyRepository */
    private $companyRepository;
    private $comfortRepository;
    private $cityRepository;
    private $companyDetailRepository;
    private $categoryRepository;
    private $serviceRepository;
    private $companyRatingRepository;

    public function __construct(
        CompanyRepository $companyRepo,
        ComfortRepository $comfortRepo,
        CityRepository $cityRepo,
        CompanyDetailRepository $companyDetailRepo,
        CategoryRepository $categoryRepo,
        ServiceRepository $serviceRepo,
        CompanyRatingRepository $companyRatingRepository
    ) {
        $this->companyRepository = $companyRepo;
        $this->comfortRepository = $comfortRepo;
        $this->cityRepository = $cityRepo;
        $this->companyDetailRepository = $companyDetailRepo;
        $this->categoryRepository = $categoryRepo;
        $this->serviceRepository = $serviceRepo;
        $this->companyRatingRepository = $companyRatingRepository;
    }

    /**
     * Display a listing of the Company.
     *
     * @param CompanyDataTable $companyDataTable
     * @return Response
     */
    public function index(CompanyDataTable $companyDataTable)
    {
        return $companyDataTable->render('catalog::companies.index');
    }

    /**
     * Show the form for creating a new Company.
     *
     * @return Response
     */
    public function create()
    {
        $cities = $this->cityRepository->all();
        $comforts = $this->comfortRepository->all();
        $categories = $this->categoryRepository->all();
        $services = [];
        $company = (object) [];
        $company->detail['work_time'] = '[
            {"isActive": true, "timeFrom": "09:00", "timeTill": "18:00", "lunchTimeFrom": null, "lunchTimeTill": null}, 
            {"isActive": true, "timeFrom": "09:00", "timeTill": "18:00", "lunchTimeFrom": null, "lunchTimeTill": null}, 
            {"isActive": true, "timeFrom": "09:00", "timeTill": "18:00", "lunchTimeFrom": null, "lunchTimeTill": null}, 
            {"isActive": true, "timeFrom": "09:00", "timeTill": "18:00", "lunchTimeFrom": null, "lunchTimeTill": null}, 
            {"isActive": true, "timeFrom": "09:00", "timeTill": "18:00", "lunchTimeFrom": null, "lunchTimeTill": null}, 
            {"isActive": false, "timeFrom": null, "timeTill": null, "lunchTimeFrom": null, "lunchTimeTill": null}, 
            {"isActive": false, "timeFrom": null, "timeTill": null, "lunchTimeFrom": null, "lunchTimeTill": null}
        ]';
        $company->detail['phones'] = [];
        $company->detail['website'] = [];
        $company->detail['email'] = [];
        return view('catalog::companies.create')->with(compact('cities', 'comforts', 'categories', 'services', 'company'));
    }

    /**
     * Store a newly created Company in storage.
     *
     * @param CreateCompanyRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyRequest $request)
    {
        $companyData = [
            'name' => $request->name,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'point' => $request->point,
            'short_desc' => $request->short_desc,
            'picture' => $request->picture ? $request->picture : [],
            'rating' => $request->rating,
            'price_rel' => $request->price_rel
        ];
        $company = $this->companyRepository->create($companyData);

        $comforts = $request->comforts;
        $company->comforts()->attach($comforts);

        $categories = $request->categories;
        $company->categories()->attach($categories);

        $companyDetail = $request->detail;
        $companyDetail['company_id'] = $company->id;
        $companyDetail['work_time'] = json_decode($request->detail['work_time']);
        $companyDetail['email'] = json_decode($request->detail['email']);
        $companyDetail['phones'] = json_decode($request->detail['phones']);
        $companyDetail['website'] = json_decode($request->detail['website']);
        $company->detail()->create($companyDetail);

        Flash::success('Company saved successfully.');

        Artisan::call('categoryCompany:count');

        return redirect(route('catalog.companies.index'));
    }

    /**
     * Display the specified Company.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            Flash::error('Company not found');

            return redirect(route('catalog.companies.index'));
        }

        $cities = $this->cityRepository->all();
        $city = $this->cityRepository->findWhere(['id' => $company->city_id])->first();
        $comforts = $this->comfortRepository->all();
        $categories = $this->categoryRepository->all();
        $company->detail['work_time'] = json_encode($company->detail['work_time']);

        return view('catalog::companies.show')->with(compact('company', 'cities', 'city',
            'comforts', 'detail', 'categories'));
    }

    /**
     * Show the form for editing the specified Company.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            Flash::error('Company not found');
            return redirect(route('catalog.companies.index'));
        }

        $categoriesId = $company->categories->pluck('id')->toArray();
        $services = $this->serviceRepository->getServicesForCompany($categoriesId);
        $rating = $this->companyRatingRepository->findByField('company_id', $id);
        $cities = $this->cityRepository->all();
        $comforts = $this->comfortRepository->all();
        $categories = $this->categoryRepository->all();
        $company->detail['work_time'] = json_encode($company->detail['work_time']);
        return view('catalog::companies.edit', compact('company', 'cities', 'comforts', 'categories',
          'services', 'rating'));
    }

    /**
     * Update the specified Company in storage.
     *
     * @param  int $id
     * @param UpdateCompanyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyRequest $request)
    {
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            Flash::error('Company not found');

            return redirect(route('catalog.companies.index'));
        }
        $companyData = [
            'name' => $request->name,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'point' => $request->point,
            'short_desc' => $request->short_desc,
            'rating' => $request->rating,
            'price_rel' => $request->price_rel
        ];
        $company = $this->companyRepository->update($companyData, $id);

        $comforts = $request->comforts ? $request->comforts : [];
        $company->comforts()->sync($comforts);

        $categories = $request->categories ? $request->categories : [];
        $company->categories()->sync($categories);

        $services = $request->services ? $request->services : [];
        $company->services()->sync($services);

        $companyDetail = $request->detail;

        $companyDetail['company_id'] = $companyDetail['company_id'] ?
            $companyDetail['company_id'] : $company->id;
        $companyDetail['work_time'] = json_decode($request->detail['work_time']);
        $companyDetail['email'] = json_decode($request->detail['email']);
        $companyDetail['phones'] = json_decode($request->detail['phones']);
        $companyDetail['website'] = json_decode($request->detail['website']);
        $this->companyDetailRepository->updateOrCreate(['company_id' => $companyDetail['company_id']], $companyDetail);

        Artisan::call('categoryCompany:count');

        Flash::success('Company updated successfully.');

        return redirect(route('catalog.companies.index'));
    }

    /**
     * Remove the specified Company from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            Flash::error('Company not found');

            return redirect(route('catalog.companies.index'));
        }

        $this->companyRepository->delete($id);

        Artisan::call('categoryCompany:count');

        Flash::success('Company deleted successfully.');

        return redirect(route('catalog.companies.index'));
    }
}
