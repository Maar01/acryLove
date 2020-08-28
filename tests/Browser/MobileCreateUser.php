<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MobileCreateUser extends DuskTestCase
{

    protected $baseMFbUrl = 'https://m.facebook.com/';
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $fbBrowser, Browser $mailBrowser) {
            // Try with a different service. When you sign up with a guerrilla mail, the new account got disabled inmediately
            $tmpMail = $mailBrowser->visit('https://www.guerrillamail.com/')->text('#inbox-id');
            $tmpMail .= '@' . $mailBrowser->value('#gm-host-select');

            $fbBrowser->visit($this->baseMFbUrl)
                ->click('#signup-button')
                ->pause('2000')
                ->type('#firstname_input', 'Maria Fernanda' )
                ->pause('1000')
                ->type('#lastname_input', 'Garza')
                ->pause('2000')
                ->driver->findElement(WebDriverBy::xpath('//*[@id="mobile-reg-form"]/div[8]/div[2]/button[1]'))
                ->click(); // xpath next

            $fbBrowser->pause('3000')
                ->select('#month', '2')
                ->pause('1000')
                ->select('#day', '10')->pause('1000')->select('#year', '2000')->pause('2000')
            ->driver->findElement(WebDriverBy::xpath('//*[@id="mobile-reg-form"]/div[8]/div[2]/button[1]'))->click();

            $fbBrowser->pause('1000')
                ->typeSlowly($tmpMail)
                ->pause('1000')
                ->clickAtXPath('//*[@id="mobile-reg-form"]/div[8]/div[2]/button[1]') //
                ->pause('2000');  // xpath

            $fbBrowser->radio('sex', '1')
                ->clickAtXPath('//*[@id="mobile-reg-form"]/div[8]/div[2]/button[1]');

            $fbBrowser->typeSlowly('matameABesosPerro@')->clickAtXPath('//*[@id="mobile-reg-form"]/div[8]/div[2]/button[4]');

        });
    }
}
