<?php

namespace Tests\Browser;

use App\FUser;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public const URL_PROFILES_TO_ADD = [
        'https://m.facebook.com/juanmanuel.hernandeziruegas',
        'https://m.facebook.com/karla.avilaruiz.3',
        'https://m.facebook.com/profile.php?id=100006355393380',
        'https://m.facebook.com/araanza.belttran',
        'https://m.facebook.com/profile.php?id=100049100013741',
        'https://m.facebook.com/claudia.gonzaleznavarro.7',
        'https://m.facebook.com/pau.calleros.1',
        'https://m.facebook.com/alan.j.cadena',
        'https://m.facebook.com/cynthia.d.diaz',
        'https://m.facebook.com/danielaortegamestas',
        'https://m.facebook.com/jennyfer.leal',
        'https://m.facebook.com/luisroberto.banuelosselaya',
        'https://m.facebook.com/aldo.avila.5851',
        'https://m.facebook.com/araceli.giggy',
        'https://m.facebook.com/danniel.sanchez',
        'https://m.facebook.com/miguel.benitezgarcia.3',
        'https://m.facebook.com/profile.php?id=100033782042681',
        'https://m.facebook.com/paolawonderwoman',
        'https://m.facebook.com/jessica.soto.399',
        'https://m.facebook.com/gvargasmeza',
        'https://m.facebook.com/eduardojair',
        'https://m.facebook.com/tanya.queen.9212?_ft_=mf_story_key.3129551480431863%3Atop_level_post_id.3129551480431863%3Atl_objid.3129551480431863%3Acontent_owner_id_new.100001311241291%3Aoriginal_content_id.145506047210088%3Aoriginal_content_owner_id.105055327921827%3Athrowback_story_fbid.3129551480431863%3Apage_id.105055327921827%3Aphoto_id.145505887210104%3Astory_location.4%3Aattached_story_attachment_style.album%3Atds_flgs.3%3Apage_insights.%7B%22105055327921827%22%3A%7B%22page_id%22%3A105055327921827%2C%22page_id_type%22%3A%22page%22%2C%22actor_id%22%3A100001311241291%2C%22attached_story%22%3A%7B%22page_id%22%3A105055327921827%2C%22page_id_type%22%3A%22page%22%2C%22actor_id%22%3A105055327921827%2C%22dm%22%3A%7B%22isShare%22%3A0%2C%22originalPostOwnerID%22%3A0%7D%2C%22psn%22%3A%22EntStatusCreationStory%22%2C%22post_context%22%3A%7B%22object_fbtype%22%3A266%2C%22publish_time%22%3A1598551195%2C%22story_name%22%3A%22EntStatusCreationStory%22%2C%22story_fbid%22%3A%5B145506047210088%5D%7D%2C%22role%22%3A1%2C%22sl%22%3A4%7D%2C%22dm%22%3A%7B%22isShare%22%3A0%2C%22originalPostOwnerID%22%3A0%7D%2C%22psn%22%3A%22EntStatusCreationStory%22%2C%22role%22%3A1%2C%22sl%22%3A4%2C%22targets%22%3A%5B%7B%22actor_id%22%3A100001311241291%2C%22page_id%22%3A105055327921827%2C%22post_id%22%3A145506047210088%2C%22role%22%3A1%2C%22share_id%22%3A0%7D%5D%7D%7D%3Athid.100001311241291%3A306061129499414%3A2%3A0%3A1601535599%3A-1990644184384434618&__tn__=%2As-R',
        'https://m.facebook.com/tanya.maldonado2?refid=8&_ft_=qid.6869075479373282712%3Amf_story_key.163423372302673917%3Aego_id.100001311241291%3Asrc.22%3Aquick_promotion_id.1559485157438515%3Aquick_promotion_instance_log_data_encoded.AX8ko8sxN062_zwJLBmkgeBKWwZaWNjDbUGQ57NtppB2U6A2SHKgN81mSB6MtVX_LR9LmfmJulGHFykBWOs3e78R4gCEQBHrKl_ZqvaHNlSv09sHvObOzvsMDirrkaqWbNZHag9zS8QobjYeqhxlQnVLSpHDab36prw30Dt_U6TiMNK3Isd5bQqFIbvpyQ5yZdJrlG80Kbiq%3Aquick_promotion_ecpm_charge.139.79283392429%3Aquick_promotion_pacing_multiplier.11924.436293535%3Aquick_promotion_auction_story_bid.561.20524925119%3Aquick_promotion_xout_quality_bid.-139.79283392429%3Aview_time.1599331264%3Afilter.h_nor&__tn__=-R',
        'https://m.facebook.com/veronica.fruttero?refid=8&_ft_=qid.6869075479373282712%3Amf_story_key.163423372302673917%3Aego_id.1450982423%3Asrc.22%3Aquick_promotion_id.1559485157438515%3Aquick_promotion_instance_log_data_encoded.AX8ko8sxN062_zwJLBmkgeBKWwZaWNjDbUGQ57NtppB2U6A2SHKgN81mSB6MtVX_LR9LmfmJulGHFykBWOs3e78R4gCEQBHrKl_ZqvaHNlSv09sHvObOzvsMDirrkaqWbNZHag9zS8QobjYeqhxlQnVLSpHDab36prw30Dt_U6TiMNK3Isd5bQqFIbvpyQ5yZdJrlG80Kbiq%3Aquick_promotion_ecpm_charge.139.79283392429%3Aquick_promotion_pacing_multiplier.11924.436293535%3Aquick_promotion_auction_story_bid.561.20524925119%3Aquick_promotion_xout_quality_bid.-139.79283392429%3Aview_time.1599331264%3Afilter.h_nor&__tn__=-R',
        'https://m.facebook.com/kamila.nails.50',
    ];

    public const URL_TO_LIKE = [
        'https://m.facebook.com/GCNailsOficial/',
        'https://m.facebook.com/gcnailsgdl/',
        'https://m.facebook.com/orangenailsgdl/',
        'https://m.facebook.com/MCnailsOficial/',
        'https://m.facebook.com/ACRYLOVEoficial/',
    ];

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
        $fbUsers = FUser::all()->sortByDesc('id');
        $fbUsers->each(function ($fbUser, $index) {
            $browser = new Browser($this->driver());
            //$this->browse(function (Browser $browser) use ($fbUser) {
            try {
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
                $this->dealAddPhoneNumber($browser);
                $browser->pause('2000');
                $this->addFriendFromList($browser, $index); //make an implementation to see if the user already was added as a friend
                $this->addFriendSetUpAccount($browser);
                $this->likeAcryLove($browser);
                //$this->uploadProfilePicture($browser);

            } catch (Exception $e) {
                //$this->captureFailuresFor(collect($browser));
                \Log::debug("Problem with user $fbUser->email: {$e->getMessage()} - {$e->getTraceAsString()}");
                $browser->screenshot($fbUser->id.'_Exception_' . $this->randomStringWithDate());
            } catch (\Throwable $t) {
                //$this->captureFailuresFor(collect($browser));
                \Log::debug("Problem with user $fbUser->email: {$t->getMessage()} - {$t->getTraceAsString()}");
                $browser->screenshot($fbUser->id.'_Throwable_' . $this->randomStringWithDate());
            }
            //$browser->storeConsoleLogsFor(collect($browser));
            $this->logOutProfile($browser);
            //implements log out
            $browser->quit();
            //});
        });
    }

    public function dealAddPhoneNumber(Browser $browser) : void
    {
        $nextXpath = '/html/body/div[1]/div/div[2]/div/div[2]/a';
        $countElement = $browser->driver->findElements(WebDriverBy::xpath($nextXpath));

        if (count($countElement)) {
            $browser->clickAtXPath($nextXpath);
        }
    }

    private function dealLoginOneTap(Browser $browser) : void
    {
        $okXpath = '/html/body/div[1]/div/div[2]/div/div[1]/div/div/div[3]/div[2]/form/div/button';
        $okElement = $browser->driver->findElements(WebDriverBy::xpath($okXpath));
        //$notNowXpath = '//*[@id="root"]/div[1]/div/div/div[3]/div[1]/div/div/a';
        if (count($okElement)) {
            $browser->clickAtXPath($okXpath);
        }
    }

    public function logOutProfile(Browser $browser)
    {
        $browser->visit('https://m.facebook.com/')->pause('3000');
        $browser->clickAtXPath('/html/body/div[1]/div/div[2]/div/div[1]/div[6]/div/a')
            ->pause('2000')
            ->clickAtXPath('/html/body/div[1]/div/div[2]/div/div[1]/div[6]/div/div/div[1]/div/div/div/div/div/div[2]/div/div[7]/a')
            ->pause('2000');
            //->clickAtXPath('/html/body/div[1]/div/div[8]/div[1]/div/div[2]/div/div/form/button');
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

    private function addFriendFromList(Browser $browser, int $index) : void
    {
        $profilesToAdd = count(self::URL_PROFILES_TO_ADD);
        $index = $index > $profilesToAdd ? ($index - $profilesToAdd) : $index;
        dd($index);
        dump(self::URL_PROFILES_TO_ADD[$index] . " {$index} this is");
        $urlToVisit = self::URL_PROFILES_TO_ADD[$index];
        if ($urlToVisit !== '') {
            $browser->visit($urlToVisit)
                ->pause('2000')
                ->clickAtXPath('/html/body/div[1]/div/div[4]/div/div[1]/div/div[1]/div/div[3]/div/div[1]/a')
                ->pause('2000');

            $this->dealPeopleYouMayKnow($browser);
            $browser->pause('2000');
            $browser->screenshot('friend_added_' . $this->randomStringWithDate());

            $browser->pause('2000');
        }

    }

    private function addFriend(Browser $browser, string $searchName = '')
    {
        $browser->visit('https://m.facebook.com/maarart.az')
            ->pause('2000')
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

    /** To add friends based on href starts with /a/mobile/friends/profile_add_friend.php m.facebook.com
     * [attribute^=value] $("[title^='Tom']") 	All elements with a title attribute value starting with "Tom"
     * ->click('a[href="/somewhere"]')
     * to add friends https://stackoverflow.com/questions/303956/select-a-which-href-ends-with-some-string
     */
}
