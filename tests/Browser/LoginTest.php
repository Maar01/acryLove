<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://m.facebook.com/')
                    ->pause(1000)
                    ->type('#m_login_email', 'luis@mezcaldevs.com')
                    ->pause(3000)
                    ->type('#m_login_password', 'P@ssw0rd')
                ->pause(3000)->driver->findElement(WebDriverBy::xpath('//*[@id="u_0_4"]/button'))
                ->click('login');

                $browser->pause(5000)
                ->screenshot('lastResultLogin' . date('Y-m-d') . '_' .random_int(1, 1000));
        });
    }
}
