<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MakeAppointmentTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_check_if_make_appointment_is_working_correctly(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitForText('SERVIÇOS | PREÇOS')
                    ->clickAtXPath('//*[@id="services"]/div/div/div[2]/div[1]/h3')
                    ->waitForText('Fazer um Agendamento')
                    ->type('subject', 'John Doe')
                    ->type('number', '22998438864')
                    ->select('category')
                    ->select('start')
                    ->waitForText('Selecione o Horário')
                    ->select('startTime')
                    ->type('body', 'Vou chegar atrasado')
                    ->press('Enviar')
                    ->waitForText('Horário agendado')
                    ->assertSee('Horário agendado');
        });
    }
}
