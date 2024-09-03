<?php

namespace Captenmasin\InertiaSeo;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Captenmasin\InertiaSeo\Components\Meta;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;

class InertiaSeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Response::macro('withMeta', function ($meta) {
            $meta = (object) $meta;
            $title = $meta->title ?? 'untitled';
            $description = $meta->description ?? '';
            $json = $meta->json ?? '';
            $preload = $meta->preload ?? [];
            $image = $meta->image ?? null;
            $canonical = $meta->url ?? url()->full();

            SEOTools::setTitle($title);
            SEOTools::setCanonical($canonical);
            SEOTools::setDescription($description);
            SEOTools::addImages([$image]);

            JsonLd::setTitle($title);
            JsonLd::setDescription($description);
            JsonLd::setImages([$image]);

            return $this->with('meta', [
                'title' => SEOMeta::getTitle(),
                'description' => SEOMeta::getDescription(),
            ])->withViewData('meta', [
                'feeds' => $meta->feeds ?? null,
                'title' => SEOMeta::getTitle(),
                'json' => $json,
                'description' => $description,
                'image' => $image,
                'canonical' => $canonical,
                'preload' => $preload,
            ]);
        });
    }

    public function boot()
    {
        Blade::componentNamespace('Captenmasin\\InertiaSeo\\Components', 'inertia-seo');
        Blade::component('meta', Meta::class);
        // <inertia-seo::meta />
    }
}
