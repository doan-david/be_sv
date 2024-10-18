<?php

namespace App\Providers;

use App\Repository\Admin\AdminRepository;
use App\Repository\Admin\AdminRepositoryInterface;
use App\Repository\Class\ClassRepository;
use App\Repository\Class\ClassRepositoryInterface;
use App\Repository\Role\RoleRepository;
use App\Repository\Role\RoleRepositoryInterface;
use App\Repository\Student\StudentRepository;
use App\Repository\Student\StudentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends  ServiceProvider
{
    public function register():void
    {

    }
    public function boot():void
    {
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ClassRepositoryInterface::class, ClassRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
    }
}
