<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TwoFactorModel extends Model {
  private $table = '2fa';
  protected $timestamps = false;
  protected $primarykey = 'tokenid';
  protected $guarded = [];
}
 ?>
