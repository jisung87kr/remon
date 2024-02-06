<?php
namespace App\Enums\Campaign;

// mission_options 테이블 아이디 참조
enum MissionOptionEnum: string
{
    case TITLE_KEYWORD_ID_OF_MISSION_OPTION = '1';
    case CONTENT_KEYWORD_ID_OF_MISSION_OPTION = '2';
    case LINK_ID_OF_MISSION_OPTION = '8';
    case HASHTAG_ID_OF_MISSION_OPTION = '11';
}
