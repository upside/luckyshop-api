<?php
/**
 * Created by PhpStorm.
 * User: upside
 * Date: 02.10.18
 * Time: 22:03
 */

namespace luckyshopApi;

use Exception;

/**
 * Class Lead
 * @package luckyshopApi
 */
class Lead
{
    public $params;

    private $phone_masks = [
        'UA' => '(38)?0\d{9}',
        'RU' => '[78]?[3489]\d{9}',
        'KZ' => '[78]?7\d{9}',
        'GE' => '995\d{8,10}',
        'AM' => '374\d{8,9}',
        'KG' => '996\d{9,10}'
    ];

    /**
     * Lead constructor.
     * @param string $name
     * @param string $phone
     * @param string $ip
     * @param string $userAgent
     * @param string $campaignHash
     * @throws Exception
     */
    public function __construct(string $name, string $phone, string $ip, string $userAgent, string $campaignHash)
    {
        $this->params = [
            'name' => $this->validateName($name),
            'phone' => $this->validatePhone($phone),
            'ip' => $this->validateIp($ip),
            'userAgent' => $userAgent,
            'campaignHash' => $campaignHash
        ];
    }

    /**
     * @param string $name
     * @return string
     * @throws Exception
     */
    private function validateName(string $name)
    {
        if (strlen($name) < 2) {
            throw new Exception('Имя должно содержать минимум 2 символа');
        }
        return $name;
    }


    /**
     * @param string $phone
     * @return string
     * @throws Exception
     */
    private function validatePhone(string $phone)
    {
        if (!preg_match('/' . implode('|', $this->phone_masks) . '/', $phone)) {
            throw new Exception('Номер телефона не соответствует маске');
        }
        return $phone;
    }

    /**
     * @param string $ip
     * @return string
     * @throws Exception
     */
    private function validateIp(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new Exception('Невалидный IP адресс');
        }
        return $ip;
    }

}