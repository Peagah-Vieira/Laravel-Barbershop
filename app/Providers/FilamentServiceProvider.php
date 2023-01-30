<?php

namespace App\Providers;

use App\Filament\Pages\MyProfile;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Perfil')
                    ->url(MyProfile::getUrl())
                    ->icon('heroicon-s-document-text'),
            ]);
        });
    }
}
