<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    // Table Name
    protected $table = "categories";

    // Primary key
    protected $primaryKey = "id";

    // Fillable columns
    protected $fillable = array(
        "category_name",
        "url_slug",
        "user_id",
        "status",
    );

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->url_slug = Str::slug($category->category_name);
        });

        static::updating(function ($category) {
            // Check if the category_name has changed
            if ($category->isDirty('category_name')) {
                $category->url_slug = Str::slug($category->category_name);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_categories');
    }
}
