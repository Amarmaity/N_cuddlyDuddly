<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCategoryGroupMasterCategory extends Model
{
    protected $table = 'home_category_group_master_category';

    protected $fillable = [
        'home_category_group_id',
        'master_category_id',
    ];
}
