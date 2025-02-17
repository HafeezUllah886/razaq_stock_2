<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeBusiness($query)
    {
        return $query->where('type', 'Business');
    }

    public function scopeSalesman($query)
    {
        return $query->where('type', 'Salesman');
    }

    public function scopeCompany($query)
    {
        return $query->where('type', 'Company');
    }

    public function transactions()
    {
        return $this->hasMany(transactions::class, 'accountID');
    }

    public function sale()
    {
        return $this->hasMany(sales::class, 'customerID');
    }
}
