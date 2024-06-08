<?php
namespace App\Dto;
use App\Dto\Dto;
class MediaContentDto extends Dto{
    private $userId;
    private $campaignId;
    private $campaignMediaId;
    private $bannerId;
    private $campaignApplicationId;
    private $contentUrl;
    private $thumbnail;
    private $title;
    private $content;
    private $author;
    private $profileImg;
    private $contentCreatedAt;

    public function __construct($userId = null, $campaignId = null, $campaignMediaId = null, $bannerId = null, $campaignApplicationId = null, $contentUrl = null, $thumbnail = null, $title = null, $content = null, $author = null, $profileImg = null, $contentCreatedAt = null)
    {
        $this->userId = $userId;
        $this->campaignId = $campaignId;
        $this->campaignMediaId = $campaignMediaId;
        $this->bannerId = $bannerId;
        $this->campaignApplicationId = $campaignApplicationId;
        $this->contentUrl = $contentUrl;
        $this->thumbnail = $thumbnail;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->profileImg = $profileImg;
        $this->contentCreatedAt = $contentCreatedAt;
    }

    public function toArray(): array
    {
        $data = [
            'user_id' => $this->userId,
            'campaign_id' => $this->campaignId,
            'campaign_media_id' => $this->campaignMediaId,
            'banner_id' => $this->bannerId,
            'campaign_application_id' => $this->campaignApplicationId,
            'content_url' => $this->contentUrl,
            'thumbnail' => $this->thumbnail,
            'title' => $this->title,
            'content' => $this->content,
            'author' => $this->author,
            'profile_img' => $this->profileImg,
            'content_created_at' => $this->contentCreatedAt,
        ];

        return array_filter($data, function ($value) {
            return !is_null($value);
        });
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @param mixed $campaignId
     */
    public function setCampaignId($campaignId): void
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return mixed
     */
    public function getCampaignMediaId()
    {
        return $this->campaignMediaId;
    }

    /**
     * @param mixed $campaignMediaId
     */
    public function setCampaignMediaId($campaignMediaId): void
    {
        $this->campaignMediaId = $campaignMediaId;
    }

    /**
     * @return mixed
     */
    public function getBannerId()
    {
        return $this->bannerId;
    }

    /**
     * @param mixed $bannerId
     */
    public function setBannerId($bannerId): void
    {
        $this->bannerId = $bannerId;
    }

    /**
     * @return mixed
     */
    public function getCampaignApplicationId()
    {
        return $this->campaignApplicationId;
    }

    /**
     * @param mixed $campaignApplicationId
     */
    public function setCampaignApplicationId($campaignApplicationId): void
    {
        $this->campaignApplicationId = $campaignApplicationId;
    }

    /**
     * @return mixed
     */
    public function getContentUrl()
    {
        return $this->contentUrl;
    }

    /**
     * @param mixed $contentUrl
     */
    public function setContentUrl($contentUrl): void
    {
        $this->contentUrl = $contentUrl;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getProfileImg()
    {
        return $this->profileImg;
    }

    /**
     * @param mixed $profileImg
     */
    public function setProfileImg($profileImg): void
    {
        $this->profileImg = $profileImg;
    }

    /**
     * @return mixed
     */
    public function getContentCreatedAt()
    {
        return $this->contentCreatedAt;
    }

    /**
     * @param mixed $contentCreatedAt
     */
    public function setContentCreatedAt($contentCreatedAt): void
    {
        $this->contentCreatedAt = $contentCreatedAt;
    }


}
