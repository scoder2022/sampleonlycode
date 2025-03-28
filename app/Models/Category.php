<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name','slug','description','parent_id','image','status'
    ];

    use HasFactory;

    public function parent()
	{
	    return $this->belongsTo(Category::class, 'parent_id');
	}

	public function children()
	{
	    return $this->hasMany(Category::class, 'parent_id');
	}

    public function products(){
	    return $this->belongsToMany(Product::class);
    }

    public function ScopeActive($query)
    {
        return $query->where('status', true);
    }

}
