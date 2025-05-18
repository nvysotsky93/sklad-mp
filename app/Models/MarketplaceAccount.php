<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketplaceAccount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'marketplace', 'api_key', 'refresh_token', 'account_name'];
}
