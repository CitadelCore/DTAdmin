<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model {
  private $table = 'tasks';
  protected $timestamps = false;
  protected $primarykey = 'taskid';
  protected $guarded = [];
}
 ?>
