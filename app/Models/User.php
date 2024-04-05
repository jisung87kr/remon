<?php

namespace App\Models;

use App\Enums\Campaign\ApplicationStatus;
use App\Enums\MediaConnectedStatusEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

//mYB1fQpROt4kVoz5H5DEgrHpiap9TEojj7kJZwbC99d64a1a
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'nick_name', 'sex', 'birthdate', 'phone', 'phone_verified_at', 'status', 'level', 'point', 'agree_email', 'agree_sms', 'agree_push',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'favoriteCampaignIds',
    ];

    public function points()
    {
        return $this->hasMany(UserPoint::class);
    }

    public function shippingAddresses()
    {
        return $this->hasMany(UserShippingAddress::class);
    }

    public function medias()
    {
        return $this->hasMany(UserMedia::class)->where('connected_status', MediaConnectedStatusEnum::CONNECTED);
    }

    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function messages()
    {
        return $this->hasMany(UserMessage::class);
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_applications', 'user_id', 'campaign_id');
    }

    public function applications()
    {
        return $this->hasMany(CampaignApplication::class, 'user_id', 'id')
            ->whereNot('status', ApplicationStatus::CANCELED->value)
            ->orderBy('id', 'desc');
    }

    public function campaignFavorites()
    {
        return $this->belongsToMany(Campaign::class, 'user_campaign_favorites', 'user_id', 'campaign_id');
    }

    public function getMedia($mediaName)
    {
        foreach ($this->medias as $index => $media) {
            if($media->media === $mediaName){
                return $media;
            }
        }

        return null;
    }

    public function getApplication(Campaign $campaign)
    {
        return $this->applications()->where('campaign_id', $campaign->id)->whereNot('status', ApplicationStatus::CANCELED->value)->first();
    }

    public function favoriteCampaignIds(): Attribute
    {
        return Attribute::make(
            get: function($value, $attribute){
                return $this->campaignFavorites()->pluck('campaigns.id')->toArray();
            },
        );
    }

    public function isFavoriteCampaign(Campaign $campaign)
    {
        return in_array($campaign->id, $this->favoriteCampaignIds);
    }
}
