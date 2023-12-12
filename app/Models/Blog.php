<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Table Name
    protected $table = "blogs";

    // Primary key
    protected $primaryKey = "id";

    // Fillable columns
    protected $fillable = array(
        "blog_title",
        "url_slug",
        "description",
        "image",
        "display_on_home",
        "user_id",
        "status",
    );

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_categories');
    }
}
