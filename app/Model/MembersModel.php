<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MembersModel extends Model {
  protected $table = 'members';
  public $timestamps = false;
  public $primaryKey = 'id';
  public $guarded = [
      'permissionlevel',
  ];
}
 ?>
