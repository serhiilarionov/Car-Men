<?php namespace Modules\Catalog\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Catalog\Entities\Comfort;
use Modules\Catalog\Repositories\ComfortRepository;

trait MakeComfortTrait
{
    /**
     * Create fake instance of Comfort and save it in database
     *
     * @param array $comfortFields
     * @return Comfort
     */
    public function makeComfort($comfortFields = [])
    {
        /** @var ComfortRepository $comfortRepo */
        $comfortRepo = \App::make(ComfortRepository::class);
        $theme = $this->fakeComfortData($comfortFields);

        return $comfortRepo->create($theme);
    }

    /**
     * Get fake instance of Comfort
     *
     * @param array $comfortFields
     * @return Comfort
     */
    public function fakeComfort($comfortFields = [])
    {
        return new Comfort($this->fakeComfortData($comfortFields));
    }

    /**
     * Get fake data of Comfort
     *
     * @param array $comfortFields
     * @return array
     */
    public function fakeComfortData($comfortFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'image' => $fake->word
        ], $comfortFields);
    }
}
