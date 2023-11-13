<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMenu extends Model
{
    use HasFactory;

    protected $table = 'tm_menu';
    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_name',
        'menu_icon',
        'menu_url',
        'menu_parent',
        'menu_description',
        'menu_status',
        'menu_nav',
        'menu_active',
        'is_deleted'
    ];

    public function menu()
    {
        return $this->hasMany(MasterMenu::class, 'menu_parent', 'menu_id')->orderBy('menu_id', 'ASC');
    }
}
