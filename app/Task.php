<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_name', 'due_date',
    ];
    
    public function users() {
        return $this->belongsTo('App\User');
    }
}
