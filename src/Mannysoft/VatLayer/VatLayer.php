<?php 

namespace Mannysoft\VatLayer;

use GuzzleHttp\Client;

class VatLayer {
    
    public $apiUrl;
    public $apiKey;
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function validateVatNumber($request)
    {
        $companyName = $request->input('company');
        $vatNumber = str_replace(' ', '', $request->input('vat_number'));
        $country = $request->country;

        if ($vatNumber == '') {
            return false;
        }
        // http://apilayer.net/api/validate?access_key=345d372cc739b313e7454aa5f1c6ae86&vat_number=CY10352115X
        $response = $this->client->get(config('vatlayer.api_url') . 'validate?' . 
            'access_key=' . config('vatlayer.api_key') .
            '&vat_number=' . $vatNumber
        );

        //$response = $this->client->get('https://vatlayer.com/php_helper_scripts/vat_api.php?secret_key=f891ab6f971af3c4b104ab8926979613&vat_number=' . $vatNumber);
        if ($response->getStatusCode() == 200) {
            //$json = $response->json();
            $json = json_decode($response->getBody(), true);
            if (isset($json['valid'])) {
                // If the VAT number is from Cyprus, Make it invalid
                if ($json['country_code'] == 'CY') {
                    return false;
                }
                return $json['valid'];
            }
            return false;
        }
        return false;
    }
}