<?php
namespace App\Services\Crawler;

use App\Util\AsyncHttpClient;
use App\Util\UserAgentUtil;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;

class NaverBLogCrawler{
    public $client;
    public $userAgent;
    public function __construct(AsyncHttpClient $client, UserAgentUtil $userAgent)
    {
        $this->client = $client;
        $this->userAgent = $userAgent;
    }
    public function getInitialState($blogId)
    {
        $cacheKey = "initial_state_{$blogId}";
        return Cache::remember($cacheKey, now()->addHour(), function() use ($blogId){
            $url = "https://m.blog.naver.com/{$blogId}";
            $request = new Request('GET', $url);
            $promise = $this->client->request($request);
            $response = $promise->wait();
            $body = (string)$response->response->getBody();

            $crawler       = new Crawler($body);
            $scriptElement = $crawler->filter('#initialState');
            $script        = $scriptElement->innerText();

            $matches = [];
            $pattern = '/window\.__INITIAL_STATE__\s*=\s*(\{.*?\});/s';
            preg_match($pattern, $script, $matches);

            if (isset($matches[1])) {
                $initialStateJson = $matches[1];
                // JSON 형식의 문자열을 배열로 파싱합니다.
                $initialState = json_decode($initialStateJson, true);
                return $initialState;
            } else {
                return null;
            }
        });
    }

    public function getRss($blogId)
    {
        $cacheKey = "rss_{$blogId}";
        return Cache::remember($cacheKey, now()->addHour(), function() use ($blogId){
            $url = "https://rss.blog.naver.com/{$blogId}.xml";
            $request = new Request('GET', $url);
            $promise = $this->client->request($request);
            $response = $promise->wait();
            $xmlString = (string)$response->response->getbody();
            $xmlObject = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
            return json_decode(json_encode($xmlObject), true);
        });
    }

    public function getFeeds($blogId)
    {
        // 캐시 키 생성
        $cacheKey = "feeds_{$blogId}";

        // 캐시가 있으면 캐시된 데이터 반환, 없으면 데이터를 캐시하고 반환
        return Cache::remember($cacheKey, now()->addHour(), function () use ($blogId) {
            $referer = 'https://m.blog.naver.com';
            $headers = [
                'User-Agent' => $this->userAgent->randomUserAgent(),
                'Content-Type' => 'application/json',
                'referer' => $referer,
            ];
            $body = json_encode($this->makeGraphqlQuery($blogId));
            $request = new Request('POST', 'https://pcmap-api.place.naver.com/graphql', $headers, $body);
            $response = $this->client->request($request)->wait();
            return json_decode((string)$response->response->getBody(), true);
        });
    }

    public function makeGraphqlQuery($blogId, $offset=0, $type='blog')
    {
        $businessId = '1516222061'; //네이버 플레이스에 검색되는 아무 아이디나 상관없음
        $query = '
        query getFeeds($businessId: String!, $blogId: String, $blogCategoryNo: String, $type: String, $feedOffset: Int, $blogOffset: Int, $isPcmap: Boolean!) {
          feeds(businessId: $businessId, blogId: $blogId, blogCategoryNo: $blogCategoryNo, type: $type, feedOffset: $feedOffset, blogOffset: $blogOffset) {
            feeds {
              ...FeedFields
              blogId
              __typename
            }
            hasMore
            blogInfo {
              id
              categoryNo
              nickname
              imageUrl
              __typename
            }
            __typename
          }
        }
        
        fragment FeedFields on Feed {
          type
          feedId
          title
          desc
          category
          period
          media {
            mediaType
            thumbnail
            videoOriginSource @include(if: $isPcmap)
            header {
              vid
              duration
              __typename
            }
            __typename
          }
          isDeleted
          isPinned
          relativeCreated
          createdString
          blogId
          id
          isLikeEnabled
          thumbnail {
            url
            isVideo
            __typename
          }
          __typename
        }
        ';

        $variables = [
            'businessId' => $businessId,
            'blogId' => $blogId,
            //            'blogCategoryNo' => '1',
            'type' => $type,
            'feedOffset' => $offset,
            'blogOffset' => $offset,
            'isPcmap' => true,
        ];

        $body = [
            'query' => $query,
            'variables' => $variables,
        ];

        return $body;
    }
}
