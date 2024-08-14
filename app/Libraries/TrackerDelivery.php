<?php
namespace App\Libraries;

use App\Util\AsyncHttpClient;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;

//https://tracker.delivery/docs/tracking-api
class TrackerDelivery{
    private $clientId;
    private $secret;

    public function __construct($clientId, $secret, AsyncHttpClient $client)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->client = $client;
        $this->url = "https://apis.tracker.delivery/graphql";
        $this->commonHeaders = [
            'Content-Type' => 'application/json',
            'Authorization' => 'TRACKQL-API-KEY ' . "$this->clientId:$this->secret",
        ];
    }

    protected function sendGraphQLRequest(string $query, array $variables)
    {
        $body = [
            'query' => $query,
            'variables' => $variables
        ];

        $request = new Request('POST', $this->url, $this->commonHeaders, json_encode($body));
        $response = $this->client->request($request)->wait();

        return $response;
    }

    /**
     * 택배사 조회
     * @param $first
     * @param $after
     * @param $searchText
     * @return mixed
     */
    public function carrierList($first=10, $after=null, $searchText=null)
    {
        $query = 'query CarrierList($first:Int, $after: String, $countryCode:String, $searchText: String) {
                    carriers(first: $first, after: $after, countryCode:$countryCode, searchText: $searchText) {
                        pageInfo {
                            hasNextPage
                            endCursor
                        }
                        edges {
                            node {
                                id
                                name
                            }
                        }
                    }
                }';

        $variables = [
            'first' => $first,
            'after' => $after,
            'countryCode' => "KR",
            'searchText' => $searchText
        ];

        return $this->sendGraphQLRequest($query, $variables);
    }

    /**
     * 운송장 정보 조회 (마지막 이벤트만)
     * @param string $carrierId
     * @param string $trackingNumber
     * @return mixed
     */
    public function lastTrack(string $carrierId, string $trackingNumber)
    {
        $query = 'query Track(
          $carrierId: ID!,
          $trackingNumber: String!
        ) {
          track(
            carrierId: $carrierId,
            trackingNumber: $trackingNumber
          ) {
            lastEvent {
              time
              status {
                code
              }
            }
          }
        }';

        $variables = [
            'carrierId' => $carrierId,
            'trackingNumber' => $trackingNumber,
        ];

        return $this->sendGraphQLRequest($query, $variables);
    }

    /**
     * 운송장 정보 조회
     * @param string $carrierId
     * @param string $trackingNumber
     * @param int $last
     * @return mixed
     */
    public function track(string $carrierId, string $trackingNumber, int $last=10)
    {
        $query = 'query Track(
          $carrierId: ID!,
          $trackingNumber: String!
          $last: Int
        ) {
          track(
            carrierId: $carrierId,
            trackingNumber: $trackingNumber,
            last: $last
          ) {
            lastEvent {
              time
              status {
                code
              }
            }
            events(last: $last) {
              edges {
                node {
                  time
                  status {
                    code
                    name
                  }
                  description
                }
              }
            }
          }
        }';

        $variables = [
            'carrierId' => $carrierId,
            'trackingNumber' => $trackingNumber,
            'last' => $last,
        ];

        return $this->sendGraphQLRequest($query, $variables);
    }

    /**
     * 웹훅등록
     * @param string $carrierId
     * @param string $trackingNumber
     * @return mixed
     */
    public function registerTrackWebhook(string $carrierId, string $trackingNumber, string $callbackUrl, string $expireAt)
    {
        $query = 'mutation RegisterTrackWebhook(
                      $input: RegisterTrackWebhookInput!
                    ) {
                      registerTrackWebhook(input: $input)
                    }';

        $variables = [
            'input' => [
                "carrierId" => $carrierId,
                "trackingNumber" => $trackingNumber,
                "callbackUrl" => $callbackUrl,
                "expirationTime" => $expireAt,
            ]
        ];

        return $this->sendGraphQLRequest($query, $variables);
    }

    public function makeExpireAt($hours=48)
    {
        $currentDateTime = Carbon::now();
        $futureDateTime = $currentDateTime->addHours($hours);
        $iso8601Format = $futureDateTime->toIso8601String();
        return $iso8601Format;
    }
}
