<?php

namespace App\Providers;

use App\Interfaces\DocumentationInterface;
use App\Interfaces\EmployeeInterface;
use App\Interfaces\EmployeeProgrammingLanguagesInterface;
use App\Interfaces\ProjectInterface;
use App\Repositories\DocumentationRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\EmployeeProgrammingLanguagesRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
     /**
     * The bindings for the repository interfaces.
     * @author AungKyawPaing
     * @var array
     */
    public $bindings = [
        EmployeeInterface::class => EmployeeRepository::class,
        EmployeeProgrammingLanguagesInterface::class => EmployeeProgrammingLanguagesRepository::class,
        ProjectInterface::class => ProjectRepository::class,
        DocumentationInterface::class => DocumentationRepository::class
    ];
     /**
     * Register the service provider.
     * @author AungKyawPaing
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeProgrammingLanguagesInterface::class, EmployeeProgrammingLanguagesRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(DocumentationInterface::class, DocumentationRepository::class);
    }
}
