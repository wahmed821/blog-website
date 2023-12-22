<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Table Name
    protected $table = "roles";

    // Primary key
    protected $primaryKey = "id";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
