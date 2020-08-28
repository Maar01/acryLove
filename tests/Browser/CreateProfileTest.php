<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateProfileTest extends DuskTestCase
{

    private $_10MinuteMail = 'https://10minutemail.com/';
    private $baseFBUrl = 'https://www.facebook.com/';
    private $tmpMailUrl = "https://temp-mail.org/";

    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testExample()
    {
        $this->browse(function (Browser $socialBrowser, Browser $emailBrowser) {
            $tmpEmail = $this->get10MinuteEmail($emailBrowser);

            $socialBrowser->visit($this->baseFBUrl)
                ->click('#u_0_2')
                ->pause('1000')
                ->type('firstname', 'Juana')
                ->pause(2000)
                ->type('lastname', 'Mezcales')
                ->pause(2000)
                ->type('reg_email__', $tmpEmail)
                ->pause(5000)
                ->type('#password_step_input', 'firstAttempt123')
                ->pause(2000)
                ->select('#day', "10")
                ->pause(3000)
                ->select('#month', "10")
                ->pause(2000)
                ->select('#year', "1992")
                ->pause(3000)
                ->radio('sex', '1')
                ->pause(3000)
                ->type('#u_1_j', $tmpEmail)
                ->pause(2000)
                ->screenshot('sign_up_data' . date('Y-m-d') . '_' .random_int(1, 1000))
                ->click('#u_1_s') //sign up u_1_s
                ->pause('10000')
                ->screenshot('lastResult' . date('Y-m-d') . '_' .random_int(1, 1000));
        });
    }

    private function get10MinuteEmail(Browser $emailBrowser): string
    {
        return $emailBrowser->visit($this->_10MinuteMail)->pause('2000')->value('#mail_address');
    }

    private function getTmpMail(Browser $emailBrowser): string
    {
        return $emailBrowser->visit($this->tmpMailUrl)->pause('3000')->value('#mail');
    }
}
