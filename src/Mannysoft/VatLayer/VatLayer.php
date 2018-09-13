<?php 

namespace Mannysoft\VatLayer;

use GuzzleHttp\Client;

class VatLayer {
    
    public $apiUrl;
    public $apiKey;
    protected $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    public function validateVatNumber($request)
    {
        $companyName = $request->input('company');
        $vatNumber = str_replace(' ', '', $request->input('vat_number'));
        $country = $request->country;

        if ($vatNumber == '') {
            return false;
        }
        
        $response = $this->client->get(config('vatlayer.api_url') . 'validate?' . 
            'access_key=' . config('vatlayer.api_key') .
            '&vat_number=' . $vatNumber
        );

        
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
