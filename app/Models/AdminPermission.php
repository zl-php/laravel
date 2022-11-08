<?php
# @Author : zhoulei1
# @Time   : 2022-11-08
# @File   : AdminPermission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $fillable = ['name', 'slug', 'http_method', 'http_path'];

    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.permissions_table'));

        parent::__construct($attributes);
    }
}
