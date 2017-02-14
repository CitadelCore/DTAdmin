<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MessagesModel extends Model {
  protected $table = 'messages';
  public $timestamps = false;
  public $primarykey = 'messageid';
  public $guarded = [];
}
 ?>
