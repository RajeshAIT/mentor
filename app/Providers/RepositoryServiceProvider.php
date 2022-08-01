<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.

        $this->app->bind(
            'App\Interfaces\CompanyInterface',
            'App\Repositories\CompanyRepository'
        );
        
        $this->app->bind(
            'App\Interfaces\PostInterface',
            'App\Repositories\PostRepository'
        );
        $this->app->bind(
            'App\Interfaces\QuestionInterface',
            'App\Repositories\QuestionRepository'
        );
        $this->app->bind(
            'App\Interfaces\AnswerInterface',
            'App\Repositories\AnswerRepository'
        );
        $this->app->bind(
            'App\Interfaces\CategoryInterface',
            'App\Repositories\CategoryRepository'
        );
        $this->app->bind(
            'App\Interfaces\ImageInterface',
            'App\Repositories\ImageRepository'
        );
        $this->app->bind(
            'App\Interfaces\UserInterface',
            'App\Repositories\UserRepository'
        );
    }
}