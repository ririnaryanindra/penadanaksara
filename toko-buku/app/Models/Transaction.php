<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['book_id','quantity','total_price'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
