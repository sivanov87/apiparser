<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\Article;
use App\Models\Setting;
use App\Models\Source;

use Carbon\Carbon;

class ScanArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan_articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan articles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $newsapiUrl = Setting::val("newsapi_url");
        $newsapiKey = Setting::val("newsapi_key");

        $url = $newsapiUrl."/everything";
        $q = urlencode(Setting::val("newsapi_query"));
        $response = Http::get($url,["q"=>$q,"apiKey"=>$newsapiKey,"sortBy"=>"publishedAt","pageSize"=>100,"language"=>"en"]);
        $data = $response->object();

        // Need process error
        if( $data->status !== "ok")
            return 0;

        foreach( $data->articles as $art )
        {
            // Проверка наличия статьи в БД
            $urlHash = md5($art->url);
            $article = Article::whereUrlHash($urlHash)->first();
            if( $article )
                continue;

            // Проверка источника в БД и добавление, при необходимости
            if( ! is_null($art->source->id))
            {
                $source = Source::whereNewsapiId($art->source->id)->first();
                if( ! $source )
                    $source = Source::create(["newsapi_id"=>$art->source->id,"name"=>$art->source->name]);
            }
            elseif(! is_null($art->source->name))
            {
                $source = Source::whereName($art->source->name)->first();
                if( ! $source )
                    Source::create(["name"=>$art->source->name]);
            }

            // Добавление статьи
            $article = new Article();
            $article->source_id = $source->id ?? 0;
            $article->url = $art->url;
            $article->url_hash = $urlHash;
            $article->title = $art->title;
            $article->description = $art->description;
            $article->content = $art->content;
            $article->url_to_image = $art->urlToImage;
            $article->published_at = Carbon::parse( $art->publishedAt );
            $article->parsed_at = Carbon::now();
            $id = $article->save();
        }
        return 0;
    }
}
