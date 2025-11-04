<?php

namespace App\Traits;
use Exception;
use Log;

trait HandlesGuzzleRequests
{
    protected function guzzleGet($url, $params  = [])
    {

         $client = new \GuzzleHttp\Client(['verify' => false]);

        try {

            $response = $client->get($url, ['query' => $params ]);

            if ($response->getStatusCode() === 200) 
            {
                return json_decode($response->getBody(), true);
            }
        } 
        catch (Exception $e) 
        {
            Log::info($e->getMessage());
        }

        return null;
    }

    protected function guzzlePost($url, $data = [], $asJson = false)
    {
        $client = new \GuzzleHttp\Client(
            ['verify' => false]
        );

        try {
            $options = $asJson ? ['json' => $data] : ['form_params' => $data];

            $response = $client->post($url, $options);

            if ($response->getStatusCode() === 200)
            {
                return json_decode($response->getBody(), true);
            }

        } 
        catch (\Exception $e) 
        {
            Log::error("Guzzle POST error: " . $e->getMessage());
        }

        return null;
    }
    public function guzzleImagePost($url, $data = [], $hasFile = false)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);

        if ($hasFile) {
            $multipart = [];

            foreach ($data as $key => $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $multipart[] = [
                        'name'     => $key,
                        'contents' => fopen($value->getRealPath(), 'r'),
                        'filename' => $value->getClientOriginalName(),
                    ];
                } else {
                    $multipart[] = [
                        'name'     => $key,
                        'contents' => $value,
                    ];
                }
            }

            $options = ['multipart' => $multipart];
        } else {
            $options = ['form_params' => $data];
        }

        try {
            return $client->post($url, $options);
        } catch (\Exception $e) {
            logger()->error('Guzzle POST error: ' . $e->getMessage());
            throw $e;
        }
    }

}
