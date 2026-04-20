<?php

namespace App\Providers;

// Clase base de proveedores de servicios en Laravel
use Illuminate\Support\ServiceProvider;

// Interfaces (contratos)
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;

// Implementaciones concretas
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;

// Service Contracts
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\UserServiceInterface;

// Service Implementations
use App\Services\AuthService;
use App\Services\UserService;

/**
 * AppServiceProvider
 *
 * Aquí se registran bindings en el contenedor de servicios de Laravel.
 * Es decir, se define qué clase concreta usar cuando se solicita una interfaz.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Método register()
     *
     * Se ejecuta al iniciar la aplicación.
     * Aquí se registran dependencias (bindings).
     */
    public function register(): void
    {
        // Cuando alguien solicite UserRepositoryInterface,
        // Laravel automáticamente inyectará UserRepository
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Cuando alguien solicite RoleRepositoryInterface,
        // Laravel inyectará RoleRepository
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);



        // Services
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Método boot()
     *
     * Se ejecuta después de registrar todos los servicios.
     * Se usa para lógica de arranque (eventos, rutas, etc.)
     */
    public function boot(): void
    {
        //
    }
}
