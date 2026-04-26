<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BaseEntity extends Entity
{

	protected $dates   = ['created_at', 'updated_at'];
	protected $model = null;
	public function __construct(?array $data = null)
	{
		parent::__construct($data);
		if($this->model !== null){
			$this->model = new $this->model();
		}
		else{
			throw new \Exception("Model not defined in entity ".get_class($this));
		}
	}

	public function save()
	{

		try{
			return $this->model->save($this);
		}
		catch (\Exception $e){
			log_message("warning", 'Failed to save diary entry '.$this->id().': ' . $e->getMessage());
			return false;
		}
	}

	public function id()
	{
		return $this->attributes[$mymodel->primaryKey] ?? null;
	}
}