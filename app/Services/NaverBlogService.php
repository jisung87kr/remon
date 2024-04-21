<?php
namespace App\Services;
use App\Enums\Campaign\MediaEnum;
use App\Enums\MediaConnectedStatusEnum;
use App\Models\User;
use App\Services\Crawler\NaverBLogCrawler;
use Illuminate\Http\Request;


class NaverBlogService{
    private NaverBLogCrawler $crawler;
    public function __construct(NaverBLogCrawler $crawler)
    {
        $this->cralwer = $crawler;
    }

    public function connect(User $user, String $url){
        $blogId = $this->getBLogIdFromUrl($url);
        $initState = $this->cralwer->getInitialState($blogId);

        if(!$blogId){
            throw new \Exception('블로그 아이디를 찾을 수 없습니다. 블로그 주소를 확인해주세요.');
        }

        if(!$initState || !$initState['blogHome']['blogHomeInfo'][$blogId]['data']['blogId']){
            throw new \Exception('블로그 정보를 찾을 수 없습니다');
        }

        if(!$this->validateNaverBlogUrl($url)){
            throw new \Exception('블로그 주소 형식이 아닙니다. 주소를 확인해주세요');
        }

        $blogInfo = [
            'url'                 => $url,
            'connected_status'    => MediaConnectedStatusEnum::CONNECTED->value,
            'media'               => MediaEnum::NAVER_BLOG->value,
            'mediaid'             => $blogId,
            'display_name'        => html_entity_decode($initState['blogHome']['blogHomeInfo'][$blogId]['data']['nickName'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?? null,
            'introduce'           => html_entity_decode($initState['blogHome']['blogIntroduce'][$blogId]['data']['introduce'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?? null,
            'profile_url'         => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['profileImagePath'] ?? null,
            'day_visitor_count'   => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['dayVisitorCount'] ?? null,
            'subscriber_count'    => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['subscriberCount'] ?? null,
            'total_visitor_count' => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['totalVisitorCount'] ?? null,
            'content_count'       => $initState['blogHome']['blogContentsCount'][$blogId]['data']['postCount'] ?? null,
            'official_blog'       => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['officialBlog'] ?? null,
            'power_blog'          => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['powerBlog'] ?? null,
            'blog_no'             => $initState['blogHome']['blogHomeInfo'][$blogId]['data']['blogNo'] ?? null,
            'raw_data'            => json_encode($initState),
        ];

        return $user->medias()->create($blogInfo);
    }

    public function getBLogIdFromUrl($url)
    {
        $parseUrl = parse_url($url);
        $result = explode('/', $parseUrl['path']);
        return $result[1];
    }

    function validateNaverBlogUrl($url) {
        // 정규식 패턴 설정
        $pattern = '/^https:\/\/(?:blog|m\.blog)\.naver\.com\/[a-zA-Z0-9_\-]+$/';

        // URL이 정규식 패턴과 일치하는지 확인
        if (preg_match($pattern, $url)) {
            return true; // 형식이 일치하는 경우
        } else {
            return false; // 형식이 일치하지 않는 경우
        }
    }
}
