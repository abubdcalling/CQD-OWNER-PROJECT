<?php

namespace App\Services;

use Google\Exception;
use Google\Service\MyBusinessBusinessInformation;
use Google_Client;
use Google_Service_BusinessProfilePerformance;
use Google_Service_MyBusiness;
use JetBrains\PhpStorm\NoReturn;

class GoogleService
{
    protected Google_Client $client;
    protected Google_Service_MyBusiness $service;
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/private/google/business-profile-449411-54fa2acadaaa.json'));
        $this->client->addScope('https://www.googleapis.com/auth/business.manage');
        $this->service = new Google_Service_MyBusiness($this->client);
    }

    /**
     */
    #[NoReturn] public function getProfile(): void
    {
        $parent = 'accounts/AIzaSyAODpRuKaE8bD_My_xnzwWyPws32fCzW70/locations/ChIJY69GG3yKdkgRdOxtgXd91fc';
        $accounts = $this->service->accounts_locations_reviews->listAccountsLocationsReviews($parent);
        dd($accounts);
    }



}
