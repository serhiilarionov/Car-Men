<?php namespace Modules\Catalog\Presenters;

use Modules\Catalog\Transformers\CompanyDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanyPresenter
 *
 * @package namespace App\Presenters;
 */
class CompanyDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanyDetailTransformer();
    }
}
