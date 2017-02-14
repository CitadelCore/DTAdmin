<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserInvitesModel extends Model {
  protected $table = 'userinvites';
  public $timestamps = false;
  public $primarykey = 'inviteid';
  public $guarded = [];
}
 ?>
