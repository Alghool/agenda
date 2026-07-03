<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Diary;

class DiaryModel extends BaseModel
{
    protected $table            = 'diaries';
    protected $primaryKey       = 'diary_id';
    protected $returnType       = \App\Entities\Diary::class;

}
