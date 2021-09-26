<?php

namespace App\Providers;

use App\Repositories\ResourceRepository;
use App\Repositories\PdfResourceRepository;
use App\Repositories\LinkResourceRepository;
use App\Repositories\HtmlResourceRepository;
use App\Repositories\Interfaces\ResourceRepositoryInterface;
use App\Repositories\Interfaces\PdfResourceRepositoryInterface;
use App\Repositories\Interfaces\LinkResourceRepositoryInterface;
use App\Repositories\Interfaces\HtmlResourceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResourceRepositoryInterface::class, ResourceRepository::class);
        $this->app->bind(PdfResourceRepositoryInterface::class, PdfResourceRepository::class);
        $this->app->bind(LinkResourceRepositoryInterface::class, LinkResourceRepository::class);
        $this->app->bind(HtmlResourceRepositoryInterface::class, HtmlResourceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
