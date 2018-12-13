<?php
/**
 * Created by PhpStorm.
 * User: dosarkz
 * Date: 2018-12-13
 * Time: 11:50
 */

namespace Dosarkz\PayPost;


use GuzzleHttp\Client;

class PayPostService extends AbstractPayment
{
    /**
     * @var
     */
    private $server_url;
    /**
     * @var
     */
    private $token;
    /**
     * @var
     */
    private $key;
    /**
     * @var
     */
    private $config;

    /**
     * Ожидает завершения оплаты пользователем
     */
    const STATUS_WAITING = 1;
    /**
     * Истекло время ожидания оплаты (5 минут)
     */
    const STATUS_EXPIRED = 2;
    /**
     * Отмена оплаты (если оплата подтверждена, то приложение сделает запрос на
     * возврат средств на карточный счет пользователя)
     */
    const STATUS_CANCELED = 3;
    /**
     * Оплата завершена успешно
     */
    const STATUS_PAID = 4;
    /**
     * Возникла ошибка при оплате (часто из за недостачи средств или запрета
     * проведений интернет-транзакций банком пользователя)
     */
    const STATUS_FAILED = 5;
    /**
     *  Был произведен перевод средств на транзитный счет клиента
     * (*Клиент – пользователь (Ticketon) который использует сервис PayPost )
     */
    const STATUS_CONFIRMED = 6;

    /**
     * PayPost constructor.
     */
    public function __construct()
    {
        $this->config = config('paypost');
        $this->config['test_mode'] ? $this->testAuth() : $this->auth();
    }

    /**
     * test auth setter
     */
    private function testAuth()
    {
        $this->server_url = $this->config['stages']['test']['url'];
        $this->token = $this->config['stages']['test']['token'];
    }

    /**
     * production auth setter
     */
    private function auth()
    {
        $this->server_url = $this->config['stages']['prod']['url'];
        $this->token = $this->config['stages']['prod']['token'];
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function generateUrl($data)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Token ' . $this->token,
            'Accept-Language' => 'ru',
            'Content-Type' => 'Application/json'
        ];

        $params = [
            'amount' => sprintf("%d", $data['amount']),
            'back_link' => $this->config['back_link'],
            'email' => $data['email'],
            'language' =>  $data['language'],
            'currency' => $data['currency'],
            'type'   =>  $data['type']
        ];

        if(array_key_exists('payment_webhook', $data))
        {
            $params['payment_webhook'] = $data['payment_webhook'];
        }

        $response = $client->post($this->getLink('generateUrl'),
            [
                'headers' => $headers,
                'body'    => json_encode($params),
            ]);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return response()->json([
                'error' => [
                    'message' => 'Ошибка в оплате. Обратитесь в службу поддержки.',
                    'errors' => []
                ]
            ], 400);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Check the payment status by id
     * @param $payment_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkStatusPay($payment_id)
    {
        return $this->request('GET', $this->getLink('generateUrl') . $payment_id,[
            'headers' => [
                'Authorization' => 'Token ' . $this->token,
                'Accept-Language' => 'ru',
                'Content-Type' => 'Application/json'
            ]
        ]);
    }

    /**
     * @param $alias
     * @return string
     */
    private function getLink($alias)
    {
        return $this->server_url . $this->config['urls'][$alias];
    }
}