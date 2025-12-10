<?php
// SPDX-License-Identifier: MIT
// (c) 2025 GegoSoft Technologies and GegoK12 Contributors

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Church
 *
 * Model for managing church/organization information.
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $state
 * @property string $city
 * @property string $pincode
 * @property string $slug
 * @property int $status
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Userprofile[] $userprofile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $event
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscription
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reminder[] $reminder
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SermonLink[] $sermonlink
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bulletin[] $bulletin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupLink[] $groupLink
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SendMail[] $sendMail
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PrayerRequest[] $prayerRequest
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PrayerResponse[] $prayerResponse
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Help[] $help
 * @mixin \Eloquent
 */
class Church extends Model
{
	protected $table = 'church';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'state','city','pincode','slug','status'
    ];

    /**
     * Get members of this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
    	return $this->hasMany('App\Models\User','church_id','id')->where('usergroup_id',5);
    }

    /**
     * Get the admins for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admin()
    {
        return $this->hasMany('App\Models\User','church_id','id')->where('usergroup_id',3);
    }

    /**
     * Get user profiles for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userprofile()
    {
        return $this->hasMany('App\Models\Userprofile','church_id','id');
    }

    /**
     * Get events for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function event()
    {
        return $this->hasMany('App\Models\Event');
    }

    /**
     * Get subscriptions for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscription()
    {
        return $this->hasMany('App\Models\Subscription','church_id','id');
    }

    /**
     * Get reminders for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reminder()
    {
        return $this->hasMany('App\Models\Reminder','church_id','id');
    }

    /**
     * Get the full address for this church.
     *
     * @return string
     */
    public function fulladdress()
    {
        $fulladdress =  $this->address
                        . "<br/>". $this->city
                        . "<br />" .$this->pincode
                        . "<br /> ". $this->state
                        . "<br /> ". "India" ;

        return $fulladdress;

    }

    /**
     * Get sermon links for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sermonlink()
    {
        return $this->hasMany('App\Models\SermonLink','church_id','id');
    }

    /**
     * Get bulletins for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bulletin()
    {
        return $this->hasMany('App\Models\Bulletin','church_id','id');
    }

    /**
     * Get groups for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function group()
    {
        return $this->hasMany('App\Models\Group','church_id','id');
    }

    /**
     * Get group links for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupLink()
    {
        return $this->hasMany('App\Models\GroupLink','church_id','id');
    }

    /**
     * Get mails sent from this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sendMail()
    {
        return $this->hasMany('App\Models\SendMail','church_id','id');
    }

    /**
     * Scope to filter active churches.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $church_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsActive($query,$church_id)
   {
       $query->where(function ($query) use($church_id)
            {
                $query  ->where('id',$church_id)
                        ->where('status',1);
            });
        return $query;
   }

   /**
     * Get count of active members for this church.
     *
     * @return int
     */
   public function getActiveMembersAttribute()
   {
        return $this->hasMany('App\Models\User','church_id','id')->with('user')->where('usergroup_id',5)->whereHas('userprofile', function ($query)
            {
                $query->where('status','active');
            })->count();
   }

   /**
     * Get count of paid members for this church.
     *
     * @return int
     */
   public function getPaidMembersAttribute()
   {
        return $this->userprofile->where('membership_type','member')->count();
   }

   /**
     * Get prayer requests for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   public function prayerRequest()
    {
        return $this->hasMany('App\Models\PrayerRequest','church_id','id');
    }

    /**
     * Get prayer responses for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prayerResponse()
    {
        return $this->hasMany('App\Models\PrayerResponse','church_id','id');
    }

    /**
     * Get help records for this church.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function help()
    {
        return $this->hasMany('App\Models\Help','church_id','id');
    }
}
