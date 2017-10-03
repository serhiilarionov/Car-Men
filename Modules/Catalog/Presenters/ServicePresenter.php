<?php

namespace Modules\Catalog\Presenters;

use Modules\Catalog\Transformers\ServiceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ServicePresenter
 *
 * @package namespace Modules\Catalog\Presenters;
 */
class ServicePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ServiceTransformer();
    }
}
