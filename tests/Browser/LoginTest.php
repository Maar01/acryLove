<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    public $profileUrl = 'https://m.facebook.com/profile.php';
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
                    ->type('#m_login_email', 'maar01art@outlook.com')
                    ->pause(3000)
                    ->type('#m_login_password', 'Mavila69@')
                ->pause(3000)->driver->findElement(WebDriverBy::xpath('//*[@id="u_0_4"]/button'))
                ->click('login');
                $browser->pause('1000');

            $this->dealLoginOneTap($browser);
            $browser->pause('5000');
            //$this->addFriend($browser); make an implementation to see if the user already was added as a friend
            $this->addFriendSetUpAccount($browser);
            $this->uploadProfilePicture($browser);

            $browser->pause(5000)
                ->screenshot('lastResultLogin' . $this->randomStringWithDate());
        });
    }

    public function uploadProfilePicture(Browser $socialBrowser)
    {
        $socialBrowser->visit($this->profileUrl)->pause('2000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div/div[2]/div/div[1]/div[2]/a')
            ->click('#nuxChoosePhotoButton')
            ->attach('#nuxPicFileInput', 'caguama_paz.jpg')
            ->waitForText('Set as Profile Picture')
            ->clickAtXPath('/html/body/div[2]/div[1]/div[2]/div/div[1]/div/div[3]/form/div[2]/div/div/button[1]')
        ->pause('5000')
        ->screenshot('upload_profile_picture_' . $this->randomStringWithDate());
    }

    public function checkLanguage(Browser $socialBrowser)
    {
        $socialBrowser->visit('https://m.facebook.com/language.php');//WIP.
    }

    private function randomStringWithDate() : string
    {
        return date('Y-m-d') . '_' .random_int(1, 1000);
    }

    private function dealLoginOneTap(Browser $browser) : void
    {
        $okXpath = '//*[@id="root"]/div[1]/div/div/div[3]/div[2]/form/div/button';
        //$notNowXpath = '//*[@id="root"]/div[1]/div/div/div[3]/div[1]/div/div/a';
        if (count($browser->driver->findElements(WebDriverBy::xpath($okXpath)))) {
            $browser->clickAtXPath($okXpath);
        }
    }

    private function addFriend(Browser $browser, string $searchName = '')
    {
        $browser->visit('https://m.facebook.com/alan.j.cadena')->pause('2000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div/div[1]/div/div[3]/div/div[1]/a')
            ->pause('2000');

        $this->dealPeopleYouMayKnow($browser);
        $browser->pause('2000');
        $browser->screenshot('friend_added_' . $this->randomStringWithDate());

        $browser->pause('2000');

        /*$searchName = urlencode('alan josue cadena');
        $addFriendUrl = "https://m.facebook.com/search/top/?q=$searchName&ref=content_filter&source=typeahead";
        $browser->visit('https://m.facebook.com/friends/center/requests/?rfj&soft=search')->pause('2000')
            ->click('#main-search-input')
            ->visit($addFriendUrl)
            ->pause('2000');*/

    }

    /**
     * @version 02/09/2020
     * @author Mario Avila
     */
    private function addFriendSetUpAccount(Browser $socialBrowser): void
    {
        //here we need to add a validation to see some text ->waitForText()
        $socialBrowser->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div[4]/div/div[2]/div/div[1]/footer/div/a')
            ->pause('1000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div[2]/div[1]/div[2]/div/div[3]/div[1]/div/div[1]/a/button')
            ->pause('3000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div[2]/div[2]/div[2]/div/div[3]/div[1]/div/div[1]/a/button')
            ->pause('3000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div[2]/div[8]/div[2]/div/div[3]/div[1]/div/div[1]/a/button')
            ->pause('3000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div[2]/div[7]/div[2]/div/div[3]/div[1]/div/div[1]/a/button');
    }

    private function dealPeopleYouMayKnow(Browser $browser)
    {
        $okXpath = '/html/body/div[1]/div[2]/div[1]/div/div[2]/div/div[4]/button';
        if (count($browser->driver->findElements(WebDriverBy::xpath($okXpath)))) {
            $browser->clickAtXPath($okXpath);
        }
    }
}
