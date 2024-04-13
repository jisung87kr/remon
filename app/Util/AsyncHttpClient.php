<?php
namespace App\Util;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;

class AsyncHttpClient{
    public $client;
    public $retryCount = 3;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request(Request $request, $retryCount = 0){
        $promise = $this->client->sendAsync($request);
        return $promise->then(
            function (Response $response) use ($request) {
                return new SuccessfulResponse($request, $response);
            },
            function (RequestException $e) use ($request, $retryCount) {
                if ($retryCount < $this->retryCount) {
                    return $this->request($request, $retryCount + 1);
                } else {
                    throw new \Exception("Request failed after {$this->retryCount} retries: " . $e->getMessage());
                }
            }
        );
    }

    public function requests($requests)
    {
        $promises = [];
        foreach ($requests as $index => $request) {
            $promises[] =  $this->request($request);
        }

        $responses = Promise\Utils::settle($promises)->wait();
        return $responses;
    }

    public function poolRequests($requests)
    {
        $fulfilledResults = [];
        $rejectedResults = [];
        $pool = new Pool($this->client, $requests, [
            'concurrency' => 5,
            'fulfilled' => function (Response $response, $index) use (&$fulfilledResults, $requests){
                $fulfilledResults[$index] = new SuccessfulResponse($requests[$index], $response);
            },
            'rejected' => function (RequestException $reason, $index) use (&$rejectedResults, $requests) {
                $rejectedResults[$index] = new FailedResponse($requests[$index], $reason);
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();

        $results = ['fulfilled' => $fulfilledResults, 'rejected' => $rejectedResults];
        return $results;
    }
}

class SuccessfulResponse{
    public $request;
    public $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}

class FailedResponse{
    public $request;
    public $reason;

    public function __construct(Request $request, RequestException $reason)
    {
        $this->request = $request;
        $this->reason = $reason;
    }
}
