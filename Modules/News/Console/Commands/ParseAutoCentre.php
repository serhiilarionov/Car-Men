<?php

namespace Modules\News\Console\Commands;

use ArandiLopez\Feed\Adapters\SimplePieItemAdapter;

class ParseAutoCentre extends ParseRss
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:autoCentre';

    /**
     * The url of rss.
     *
     * @var string
     */
    private $rssUrl = 'https://www.autocentre.ua/news/feed';


    /**
     * Create a new rss instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->runParse($this->rssUrl);
    }

    /**
     * Method for preparing information for article model
     * @param SimplePieItemAdapter $data
     * @return array
     */
    public function prepareDataNews(SimplePieItemAdapter $data)
    {
        $news = [];
        $news['title'] = $data->title;
        $news['source_id'] = 1;
        $news['source_link'] = $data->link ?: '';
        $news['publication_date'] = date("Y-m-d H:m:s", strtotime($data->date));

        //get first img from content
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $data->content, $image);
        $news['image'] = count($image) ? $image['src'] : '';
        
        //replace of html tags
        $news['text'] = preg_replace('#<p>(Запись)[^>]*?>.*?<\/p>|<div class="td-gallery-slide-count(.)*\R?(.)*<\/div>#',
          '', $data->content);
        $news['text'] = preg_replace('#<!--see-also-->[^\R]*?<!--end-see-also-->#', '', $news['text']);
        $news['text'] = preg_replace('#<[^>]*>|(\s\s)+|\\r\\n|\\n#', '', $news['text']);
        $news['text'] = trim($news['text']);
        
        //tags
        $categories = [];
        foreach ($data->categories as $key => $category) {
            $categories[$key] = $category->term;
        }
        $news['tags'] = json_encode($categories);

        return $news;
    }
}
