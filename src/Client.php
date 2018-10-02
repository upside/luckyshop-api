<?php

namespace luckyshopApi;

class Client
{
    private $api_key;

    private $lead_url = 'https://luckyshop.ru/api-webmaster/lead.html';
    private $status_url = 'https://luckyshop.ru/api-webmaster/lead-status-batch.html';

    private $result = null;

    /**
     * Client constructor.
     * @param $api_key
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }


    /**
     * @param Lead $lead
     * @param array $utm
     * @return mixed
     */
    public function sendLead(Lead $lead, $utm = [])
    {
        return $this->result = json_decode($this->request($lead->params, $utm));
    }


    /**
     * @param Click $click
     * @return mixed
     */
    public function getStatuses(Click $click)
    {
        return $this->result = json_decode($this->request($click->click));
    }

    /**
     * @return bool
     */
    public function check()
    {
        if (is_null($this->result)) {
            return false;
        }

        return $this->result->success === 'success' ? true : false;
    }


    /**
     * @param array $params
     * @param array $utm
     * @param string $type
     * @param string $method
     * @return bool|string
     */
    private function request($params = [], $utm = [], $type = 'lead', $method = 'POST')
    {
        $base_url = $type === 'lead' ? $this->lead_url : $this->status_url;

        $data = http_build_query($params);

        $opts = [
            'http' => [
                'method' => $method,
                'content' => $data
            ]
        ];

        $context = stream_context_create($opts);
        $result = file_get_contents($base_url . '?api_key=' . $this->api_key . '&' . http_build_query($utm), false, $context);

        return $result;
    }

}