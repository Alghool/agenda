<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BaseEntity extends Entity
{

	protected $dates   = ['created_at', 'updated_at'];
	protected $model = null;
	private ?\CodeIgniter\Model $modelInstance = null;
	private bool $withoutValidationFlag = false;
	protected $casts   = [
		'created_at' => 'datetime'
	];
	public function __construct(?array $data = null)
	{
		parent::__construct($data);
		$this->getModelInstance();
	}

	protected function getModelInstance($forceNew = false){
		if( $this->modelInstance === null ){
			$this->modelInstance = new $this->model();
		}
		return ($forceNew)? new $this->model() : $this->modelInstance;
	}


	public function save()
	{

		try{
			if($this->id){
				$result = $this->modelInstance->update($this->id, $this);
			}else{
				$result = $this->modelInstance->save($this);
			}

			if($this->withoutValidationFlag){
				$this->modelInstance->skipValidation(false);
				$this->withoutValidationFlag = false;
			}
			return $result;
		}
		catch (\Exception $e){
			log_message("warning", 'Failed to save entry '.$this->id().': ' . $e->getMessage());
			return false;
		}
	}

	public function withoutValidation(): BaseEntity
	{
		$this->modelInstance->skipValidation();
		$this->withoutValidationFlag = true;
		return $this;
	}

	public function id()
	{
		return $this->attributes[$this->modelInstance->primaryKey] ?? null;
	}

	public function getErrors(bool $forceDB = false){
		return $this->modelInstance->errors($forceDB);
	}

	public function __get(string $key)
	{
		if ($key === 'id') {
			return $this->id();
		}
		return parent::__get($key);
	}
}