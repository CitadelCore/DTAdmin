<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroupsModel extends Model {
  protected $table = 'usergroups';
  public $timestamps = false;
  public $primarykey = 'groupid';
  public $guarded = [];
}
 ?>
