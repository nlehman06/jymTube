<?php

namespace App;

use App\StreamingServices\FacebookService;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Categories\Traits\Categorizable;

/**
 * App\Video
 *
 * @property int $id
 * @property string $provider
 * @property string $provider_id
 * @property string $title
 * @property string $description
 * @property string $permalink_url
 * @property string $length
 * @property string $picture
 * @property string $created_time
 * @property string $from_id
 * @property string $from_name
 * @property string $from_profile
 * @property int $submitted_by_user_id
 * @property string $submitted_date
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video submitted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereCreatedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereFromProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video wherePermalinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereSubmittedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereSubmittedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Video whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Video extends Model {

    use Categorizable;

    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function getFromProfileAttribute()
    {
        if ($this->provider !== 'facebook')
        {
            return $this->from_profile;
        }

        return (new FacebookService())->getDataFromProvider($this->provider_id)['from_profile'];
    }

    public function getPictureAttribute()
    {
        if ($this->provider !== 'facebook')
        {
            return $this->picture;
        }

        return (new FacebookService())->getDataFromProvider($this->provider_id)['picture'];
    }
}
