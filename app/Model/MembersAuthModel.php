<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MembersAuthModel extends Authenticatable {
  use Notifiable;
  protected $table = 'members';
  public $timestamps = false;
  public $primaryKey = 'id';
  protected $fillable = [
      'userid', 'email', 'password', 'firstname', 'lastname', 'disabled',
  ];
  protected $hidden = [
      'password', 'remember_token',
  ];
}
 ?>
