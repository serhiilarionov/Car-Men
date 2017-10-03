<?php

namespace Modules\Catalog\Http\Controllers;

use Modules\Catalog\DataTables\CategoryDataTable;
use Modules\Catalog\Entities\Service;
use Modules\Catalog\Http\Requests;
use Modules\Catalog\Http\Requests\CreateCategoryRequest;
use Modules\Catalog\Http\Requests\UpdateCategoryRequest;
use Modules\Catalog\Repositories\CategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Modules\Catalog\Repositories\ServiceRepository;
use Response;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;
    private $serviceRepository;

    public function __construct(CategoryRepository $categoryRepo, ServiceRepository $serviceRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('catalog::categories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        $mainCategories = $this->categoryRepository->findWhere(['parent_id' => null]);

        $services = $this->serviceRepository->findWhere(['category_id' => null]);

        return view('catalog::categories.create')->with(compact('mainCategories', 'services'));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        if (!$input['parent_id']) {
            $input['parent_id'] = null;
        }

        $category = $this->categoryRepository->create($input);

        Flash::success('Category saved successfully.');

        return redirect(route('catalog.categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $category = $this->categoryRepository->findWithoutFail($id);
        $parentCategory = $this->categoryRepository->findWhere(['id' => $category->parent_id])->first();
        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('catalog.categories.index'));
        }

        return view('catalog::categories.show')->with(compact('category', 'parentCategory'));
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        $services = $this->serviceRepository->getServices($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('catalog.categories.index'));
        }

        $mainCategories = $this->categoryRepository->findWhere(['parent_id' => null, ['id', '!=', $id]]);

        return view('catalog::categories.edit')->with(compact('category', 'mainCategories',
            'mainCategoriesSelectOptions', 'services'));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('catalog.categories.index'));
        }

        $categoryData = [
            'name' => $request->name,
            'parent_id' => $request->parent_id ? $request->parent_id : null,
            'active' => $request->active
        ];

        $this->categoryRepository->update($categoryData, $id);

        $servicesId = $request->services ? $request->services : [];
        
        $this->serviceRepository->syncCategory($servicesId, $id);

        Flash::success('Category updated successfully.');

        return redirect(route('catalog.categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('catalog.categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('catalog.categories.index'));
    }
}
