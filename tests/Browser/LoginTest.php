<?php

namespace Tests\Browser;

use App\FUser;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public $profileUrl = 'https://m.facebook.com/profile.php';

    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            //'--disable-gpu',
            //'--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        )
        );
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $fbUsers = FUser::all();
        $fbUsers->each(function ($fbUser) {
            $browser = new Browser($this->driver());
            //$this->browse(function (Browser $browser) use ($fbUser) {
                $browser->visit('https://m.facebook.com/')
                    ->pause(1000)
                    ->type('#m_login_email', $fbUser->email)
                    ->pause(3000)
                    ->type('#m_login_password', $fbUser->f_password)
                    ->pause(3000)
                    ->driver->findElement(WebDriverBy::xpath('//*[@id="u_0_4"]/button'))
                    ->click('login');
                $browser->pause('5000');

                $this->dealLoginOneTap($browser);
                $browser->pause('5000');
                $this->addFriend($browser); //make an implementation to see if the user already was added as a friend
                //$this->addFriendSetUpAccount($browser);
                $this->likeAcryLove($browser);
                //$this->uploadProfilePicture($browser);
                $browser->quit();
            //});
        });

    }

    /**
     * @param Browser $socialBrowser
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     * @version 07/09/2020
     * @author Mario Avila W.I.P.
     */
    public function uploadProfilePicture(Browser $socialBrowser)
    {
        $socialBrowser->visit($this->profileUrl)->pause('2000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div/div[1]/div/div[1]/div[2]/a')
            ->click('#nuxChoosePhotoButton')
            ->attach('#nuxPicFileInput', 'caguama_paz.jpg')
            ->waitForText('Set as Profile Picture')
            ->clickAtXPath('/html/body/div[2]/div[2]/div[2]/div/div[1]/div/div[3]/form/div[2]/div/div/button[1]')
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
        $okXpath = '/html/body/div[1]/div/div[2]/div/div[1]/div/div/div[3]/div[2]/form/div/button';
        $okElement = $browser->driver->findElements(WebDriverBy::xpath($okXpath));
        //$notNowXpath = '//*[@id="root"]/div[1]/div/div/div[3]/div[1]/div/div/a';
        dump(count($browser->driver->findElements(WebDriverBy::xpath($okXpath))));
        if (count($okElement)) {
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
        if (count($socialBrowser->driver->findElements(WebDriverBy::xpath('/html/body/div[1]/div/div[4]/div/div[5]/div[4]/div/div[2]/div/div[1]/footer/div/a')))) {
            $socialBrowser->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[5]/div[4]/div/div[2]/div/div[1]/footer/div/a');
        } else {
            $socialBrowser->visit('https://m.facebook.com/friends/center/requests/');
        }

        $socialBrowser->pause('3000') //
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[2]/div[4]/div[1]/div[2]/div/div[3]/div[1]/div/div[1]/a/button')
            ->pause('3000');

        // confirm i know that person
        if (count($socialBrowser->driver->findElements(WebDriverBy::xpath('/html/body/div[1]/div[2]/div[1]/div/div[2]/div/div[3]/div/div[2]/form/button')))) {
            $socialBrowser->clickAtXPath('/html/body/div[1]/div[2]/div[1]/div/div[2]/div/div[3]/div/div[2]/form/button');
        }

        /*$socialBrowser->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[2]/div[4]/div[2]/div[2]/div/div[3]/div[1]/div/div[1]/a/button')
            ->pause('3000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[2]/div[4]/div[4]/div[2]/div/div[3]/div[1]/div/div[1]/a/button')
            ->pause('3000')
            ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[2]/div[4]/div[7]/div[2]/div/div[3]/div[1]/div/div[1]/a/button');*/
    }

    private function dealPeopleYouMayKnow(Browser $browser)
    {
        $okXpath = '/html/body/div[1]/div[2]/div[1]/div/div[2]/div/div[4]/button';
        if (count($browser->driver->findElements(WebDriverBy::xpath($okXpath)))) {
            $browser->clickAtXPath($okXpath);
        }
    }

    private function likeAcryLove(Browser $socialBrowser)
    {
        $socialBrowser->visit('https://m.facebook.com/ACRYLOVEoficial/')->pause('3000');
        $socialBrowser->clickAtXPath('/html/body/div[1]/div/div[4]/div/div/div/div[1]/div[2]/div[2]/div/div/div[3]');
    }
}
