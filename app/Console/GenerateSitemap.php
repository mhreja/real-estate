<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

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
     * @return bool
     */
    public function handle()
    {

        $sitemap = SitemapGenerator::create(config('app.url'))
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->ignoreRobots();
                $crawler->setMaximumDepth(3);
            })
            ->hasCrawled(function (Url $url) {
                ## avoid creating duplicate
                if (in_array($url->segment(1), ['sitemap'])) {
                    return;
                }

                return $url;
            })
            ->getSitemap();

        $isProcess = $sitemap->writeToFile(public_path('sitemap.xml'));

        return (bool)$isProcess;
    }
}
