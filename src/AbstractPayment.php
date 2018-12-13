<?php
/**
 * Created by PhpStorm.
 * User: dosar
 * Date: 27.11.2018
 * Time: 11:14
 */

namespace Dosarkz\PayPost;

use GuzzleHttp\Client;

/**
 * Class AbstractPayment
 * @package App\Services\Paypost
 */
abstract class AbstractPayment
{
    /**
     * @param $data
     * @return mixed
     */
    abstract public function generateUrl($data);

    /**
     * @param $method
     * @param $uri
     * @param $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, $options)
    {
        $client = new Client();

        $response = $client->request($method,  $uri, $options);
        $body = $response->getBody();

        $result = json_decode($body->getContents());

        if($response->getStatusCode() != 200)
        {
            return response()->json([
                'error' => [
                    'message' => 'oops something went wrong. Please contact to author repository',
                    'errors' => []
                ]
            ], 400);
        }

        return $result;
    }
}