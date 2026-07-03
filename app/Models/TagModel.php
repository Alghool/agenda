<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends BaseModel
{
    protected $table            = 'tags';
    protected $primaryKey       = 'tag_id';
    protected $returnType       = \App\Entities\Tag::class;

	protected $beforeDelete   = ["beforeDelete"];

	function beforeDelete($data){
		//remove parent id for deleted tags' children
		foreach($data["id"] as $id){
			$childrenTag = $this->where("parent_id", $id)->findAll();
			foreach($childrenTag as $child){
				$child->parent_id = 0;
				$child->full_name = $child->text;
				$child->save();
			}
		}
	}

	function update($id = null, $entity = null):bool{
		if($entity->hasChanged('text') || $entity->hasChanged('parent_id')){
			if($entity->parent_id != 0){
				$parent = $this->find($entity->parent_id);
				$entity->full_name = $parent->full_name."\\" .$entity->text ;
			}
			else{
				$entity->full_name = $entity->text;
			}
			$this->updateChildrenFullName($entity->id, $entity->full_name);
		}

		return parent::update($id, $entity);
	}

	function updateChildrenFullName($parentId, $parentFullName){
		$children = $this->where('parent_id', $parentId)->findAll();
		foreach($children as $child){
			$child->full_name = $parentFullName."\\".$child->text;
			$this->update($child->id, $child);
		}
	}

}
