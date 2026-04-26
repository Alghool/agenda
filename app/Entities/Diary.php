<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Diary extends BaseEntity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
	protected $casts = [
		'created_at' => 'datetime'
	];
	protected $model = \App\Models\DiaryModel::class;

	public function save()
	{
		$diaryModel = new \App\Models\DiaryModel();
		try{
			return $diaryModel->save($this);
		}
		catch (\Exception $e){
			log_message("warning", 'Failed to save diary entry '.$this->id().': ' . $e->getMessage());
			return false;
		}
	}

	public function id()
	{
		$diaryModel = new \App\Models\DiaryModel();
		return $this->attributes[$diaryModel->primaryKey] ?? null;
	}

}
