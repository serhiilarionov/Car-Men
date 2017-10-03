<?php

namespace Modules\Catalog\Presenters;

use Modules\Catalog\Transformers\CompanyRatingCategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanyRatingCategoryPresenter
 *
 * @package namespace Modules\Catalog\Presenters;
 */
class CompanyRatingCategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanyRatingCategoryTransformer();
    }
}
