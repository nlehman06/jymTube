<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    protected $guarded = [];

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }
}
