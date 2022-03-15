<?php

namespace App\Traits;

trait HubSpotService
{

    public function getContacts(){
        $client = new \GuzzleHttp\Client();

        $request = $client->get(config('services.hubspot.contacts_url').'?hapikey='.config('services.hubspot.apikey'));
        $response = json_decode($request->getBody()->getContents(),true);
        $data = array_map(function ($item){
            $main_mail = null;
            foreach ($item['identity-profiles'][0]['identities'] as $row){
                if(isset($row['is-primary']) && $row['is-primary']) {
                    $main_mail = $row['value'];
                    break;
                }
            }

            return [
                'hubspot_id'=> $item['vid'],
                'firstname'=>$item['properties']['firstname']['value'],
                'lastname'=>$item['properties']['firstname']['value'],
                'email'=>$main_mail
            ];
        },$response['contacts']);

        return $data;
    }
}
