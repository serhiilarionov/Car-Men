<?php

namespace Modules\Auth\Presenters;

use Modules\Auth\Transformers\PushLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PushLogPresenter
 *
 * @package namespace Modules\Auth\Presenters;
 */
class PushLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PushLogTransformer();
    }
}
