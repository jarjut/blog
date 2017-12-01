<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Option;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * View Composer.
         */
        view()->composer('layouts.sidebar', function($view){
          //Category without announcement
          $data = array(
            'categories' => \App\Category::whereNotIn('category_id', [2])->get(),
            'announcement' => \App\Post::whereHas('categories', function($q){
              $q->where('kategoripost.category_id','=','2');
              })
            ->latest()->take(5)->get(),
            'populars' => \App\Post::orderBy('view','desc')->take(5)->get()
          );
          $view->with($data);
        });

        view()->composer('layouts.master', function($view){
          $data = array(
            'title' => Option::getOptionValue('title'),
            'description' => Option::getOptionValue('description'),
            'banner_title' => Option::getOptionValue('banner-title'),
            'banner_sub_title' => Option::getOptionValue('banner-sub-title'),
            'color_theme' => Option::getOptionValue('color-theme'),
            'logo' => Option::getOptionValue('logo-text')
          );
          $view->with($data);
        });

        view()->composer('home', function($view){
          $data = array(
            'title' => Option::getOptionValue('title'),
            'description' => Option::getOptionValue('description'),
            'headline' => \App\Post::where('headline', 1)->with(['user', 'comments', 'categories'])->latest()->first(),
          );
          $view->with($data);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
