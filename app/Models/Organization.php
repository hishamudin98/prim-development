<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = ['nama', 'code', 'email', 'telno', 'address', 'postcode', 'state'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }

    public function donation()
    {
        return $this->belongsToMany(Donation::class, 'donation_organization');
    }
}
