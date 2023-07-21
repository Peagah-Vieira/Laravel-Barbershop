<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }
    
    public function test_check_if_login_function_is_working(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->press('@login-button')
                    ->waitForText('Painel de Controle')
                    ->assertsee('Painel de Controle')
                    ->logout();
        });
    }
    
    public function test_check_if_already_logged_user_is_successfully_redirected(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->waitForText('Painel de Controle')
                    ->assertsee('Painel de Controle')
                    ->logout();
        });
    }
}
