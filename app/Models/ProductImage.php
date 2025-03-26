<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id','user_id','is_main_image','path'];
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageBysize($size){
        $image_path = [];
        $sizes = config( 'image.sizes' );
        $relativePath = $this->path;
        foreach ( $sizes as $sizeName => $value ) {
            $baseName     = basename( $relativePath );
            $sizeNamePath = str_replace( $baseName, $sizeName . "-" . $baseName, $relativePath );
            $image_path[$sizeName] = $sizeName . "-" . $baseName;
        }
    }

}
