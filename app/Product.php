<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const FIELD_NAME = 'name';
    const FIELD_DESCRIPTION = 'description';

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
}
