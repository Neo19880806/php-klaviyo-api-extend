<?php

namespace Siro\Klaviyo;

use GuzzleHttp\Client;

class KlaviyoTemplate extends KlaviyoResponse
{
    private $apiKey;
    private $client;

    public function __construct($apiKey, $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * GET /api/v1/email-templates
     */
    public function getAll()
    {
        $response = $this->client->get('/api/v1/email-templates', [
            'query' => [
                'api_key' => $this->apiKey
            ]
        ]);

        return $this->sendResponseAsObject($response);
    }

    /**
     * POST /api/v1/email-templates
     */
    public function create($name, $htmlTemplate)
    {
        $requestParams = [
            'form_params' => [
                'api_key' => $this->apiKey,
                'name' => $name,
                'html' => $htmlTemplate,
            ]
        ];
        $response = $this->client->post('/api/v1/email-templates', $requestParams);

        return $this->sendResponseAsObject($response);
    }

    /**
     * PUT /api/v1/email-template/{{ TEMPLATE_ID }}
     */
    public function update($templateId, $name, $htmlTemplate)
    {
        $requestParams = [
            'form_params' => [
                'api_key' => $this->apiKey,
                'name' => $name,
                'html' => $htmlTemplate,
            ]
        ];
        $response = $this->client->put("/api/v1/email-template/{$templateId}", $requestParams);

        return $this->sendResponseAsObject($response);
    }

    /**
     * DELETE /api/v1/email-template/{{ TEMPLATE_ID }}
     */
    public function delete($templateId)
    {
        $requestParams = [
            'form_params' => [
                'api_key' => $this->apiKey,
            ]
        ];
        $response = $this->client->delete("/api/v1/email-template/{$templateId}", $requestParams);
        return $this->sendResponseAsObject($response);
    }

    /**
     * POST /api/v1/email-template/{{ TEMPLATE_ID }}/clone
     */
    public function clone($templateId, $newName)
    {
        $requestParams = [
            'form_params' => [
                'api_key' => $this->apiKey,
                'name'    => $newName
            ]
        ];
        $response = $this->client->post("/api/v1/email-template/{$templateId}/clone", $requestParams);
        return $this->sendResponseAsObject($response);
    }

    /**
     * POST /api/v1/email-template/{{ TEMPLATE_ID }}/render
     */
    public function render($templateId, array $context = [])
    {
        $requestParams = [
            'form_params' => [
                'api_key' => $this->apiKey,
                'context'    => json_encode($context)
            ]
        ];
        $response = $this->client->post("/api/v1/email-template/{$templateId}/render", $requestParams);
        return $this->sendResponseAsObject($response);
    }

    /**
     * POST /api/v1/email-template/{{ TEMPLATE_ID }}/send
     */
    public function renderAndSend($templateId, $fromEmail, $fromName, $subject, $to, array $context = [])
    {
        $requestParams = [
            'form_params' => [
                'api_key'    => $this->apiKey,
                'from_email' => $fromEmail,
                'from_name'  => $fromName,
                'subject'    => $subject,
                'to'         => $to,
                'context'    => json_encode($context)
            ]
        ];
        $response = $this->client->post("/api/v1/email-template/{$templateId}/send", $requestParams);
        return $this->sendResponseAsObject($response);
    }

    /**
     * POST /api/v1/email-template/{{ TEMPLATE_ID }}/send
     */
    public function send($templateId, $fromEmail, $fromName, $subject, $to, array $context = [])
    {
        return $this->renderAndSend($templateId, $fromEmail, $fromName, $subject, $to, $context);
    }
}
