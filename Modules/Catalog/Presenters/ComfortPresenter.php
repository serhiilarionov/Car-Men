<?php namespace Modules\Catalog\Presenters;

use Modules\Catalog\Transformers\ComfortTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ComfortPresenter
 *
 * @package namespace App\Presenters;
 */
class ComfortPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ComfortTransformer();
    }
}
