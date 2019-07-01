<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\{
    Article,
    Product\Product,
    Opinion\Comment,
    Places\City,
    Financial\Order,
    Opinion\QuestionAndAnswer,
    Opinion\Review,
    Promocode\Promocode,
    Discount\Discount
};
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Helpers\MediaConversionsTrait;

class User extends Authenticatable implements AuditableContract, HasMedia
{
    use LaratrustUserTrait, HasApiTokens, Filterable, CreateTimeline;
    use Notifiable, SoftDeletes, HasTenant, Auditable;
    use HasMediaTrait, MediaConversionsTrait;

    /****************************************
     **             Attributes
     ***************************************/


    protected static $has_user = false;

    /**
     * The attributes specifies that table has char type id
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes defines use uuid when creating
     * or auto increment integer
     *
     * @var boolean
     */
    protected static $create_uuid = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'first_name',
        'last_name',
        'social_links',
        'email',
        'password',
        'national_code',
    ];
    
    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'city_id',
        'first_name',
        'last_name',
        'social_links',
        'email',
        'password',
        'national_code',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phones'        => 'array',
        'social_links'  => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    
    /****************************************
     **         Scopes & Mutators
     ***************************************/
    
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    /****************************************
     **             Relations
     ***************************************/
    
    /**
     * Get all the articles that the user wrote them
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get all the products that the user regirster them
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all the promocodes that owned the promocode & adverb
     */
    public function promocodes()
    {
        return $this->belongsToMany(Promocode::class);
    }

    /**
     * Get all the discounts that the user
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * Get all the phones that owned by the user
     */
    public function phones()
    {
        return $this->hasMany(UserPhone::class);
    }

    /**
     * Get all the phones that owned by the user
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Get all of the favorites products
     */
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }

    /**
     * Get all the audits that the user wrote them
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * each user live in one city
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all the question_and_answers of the users.
     */
    public function question_and_answers()
    {
        return $this->hasMany(QuestionAndAnswer::class);
    }

    /**
     * Get all the orders of the users.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all the orders items of the users.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all the orders of the users.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the media field of the model
     */
    public function avatar()
    {
        return $this->morphMany(config('medialibrary.media_model'), 'model');
    }
}