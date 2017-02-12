<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserInvitesModel extends Model {
  private $table = 'userinvites';
  protected $timestamps = false;
  protected $primarykey = 'inviteid';
  protected $guarded = [];
}
 ?>
