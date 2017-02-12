<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroupsModel extends Model {
  private $table = 'usergroups';
  protected $timestamps = false;
  protected $primarykey = 'groupid';
  protected $guarded = [];
}
 ?>
