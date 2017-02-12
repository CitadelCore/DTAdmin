<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MembersModel extends Model {
  private $table = 'members';
  protected $timestamps = false;
  protected $primaryKey = 'id';
  protected $guarded = [
      'permissionlevel',
  ];
}
 ?>
