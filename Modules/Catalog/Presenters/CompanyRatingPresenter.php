<?php

namespace Modules\Catalog\Presenters;

use Modules\Catalog\Transformers\CompanyRatingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanyRatingPresenter
 *
 * @package namespace Modules\Catalog\Presenters;
 */
class CompanyRatingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanyRatingTransformer();
    }
}
