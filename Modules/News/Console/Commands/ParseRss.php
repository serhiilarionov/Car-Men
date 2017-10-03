<?php

namespace Modules\News\Console\Commands;

use Illuminate\Console\Command;
use Modules\News\Entities\Article;
use ArandiLopez\Feed\Factories\FeedFactory;
use ArandiLopez\Feed\Adapters\SimplePieItemAdapter;

abstract class ParseRss extends Command
{

    /**
     * Abstract method for preparing information for article model
     * @param SimplePieItemAdapter $data
     * @return mixed
     */
    abstract protected function prepareDataNews(SimplePieItemAdapter $data);


    /**
     * Starting parse
     * @param String $rssUrl
     */
    public function runParse($rssUrl)
    {
        $feedFactory = new FeedFactory(['cache.enabled' => false]);
        $feeder = $feedFactory->make($rssUrl);
        $this->saveNews($feeder->items);
    }

    /**
     * Save information to database
     * @param array $list
     */
    public function saveNews(Array $list)
    {
        $length = count($list);
        for($i = 0; $i < $length; $i++) {
            $newsExist = Article::where('source_link', $list[$i]->link)->first();
            if($newsExist) {
                break;
            }
            $preparedNews = $this->prepareDataNews($list[$i]);
            $newCompany = new Article($preparedNews);
            $newCompany->save();
        }
    }
}
