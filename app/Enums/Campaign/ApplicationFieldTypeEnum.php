<?php
namespace App\Enums\Campaign;

enum ApplicationFieldTypeEnum:string
{
    case TEXT = 'text';
    case SELECT = 'select';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case TEXTAREA = 'textarea';
}
