<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningMaterial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','category_id','title','description','thumbnail',
        'file_url','video_url','type','is_member_only','downloads','views',
    ];
    protected $casts = ['is_member_only' => 'boolean'];

    public function user()     { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
