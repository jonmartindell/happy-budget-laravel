<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['category_id', 'merchant', 'amount', 'date', 'transfer'];

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a User model
    }

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class); // Assuming you have a Category model
    }

    // Scopes
    public function scopeTransfers($query)
    {
        return $query->where('transfer', true);
    }

    public function scopeNonTransfers($query)
    {
        return $query->whereIn('transfer', [false, null]);
    }

    // You can also define a default order for the model in Laravel's boot method
    protected static function booted()
    {
        parent::boot();

        static::addGlobalScope('date', function ($query) {
            $query->orderByDesc('date');
        });
    }
}
