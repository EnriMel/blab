<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blab extends Model
{
   protected $fillable = [
    'message',
   ];

   public function user() {
      $this->belongsTo(User::class);
   }
}
