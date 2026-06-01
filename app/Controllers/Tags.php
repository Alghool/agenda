<?php

namespace App\Controllers;

use App\Entities\Tag;
use App\Models\TagModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class Tags extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
	    $twig = new \Alghool\Twig\Twig();
	    $tagModel = new TagModel();
	    $tags = $tagModel->orderBy("created_at", "DESC")->findAll();

	    return $twig->render( 'tagPage', ['tags' =>$tags] );
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
	    $twig = new \Alghool\Twig\Twig();
	    $tagModel = new TagModel();
	    $tags = $tagModel->orderBy("created_at", "DESC")->findAll();

	    return $twig->render( 'tagEditPage', ['tags' =>$tags, 'tag' => $tagModel->find($id)] );
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {

    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
	    $tag = new Tag();
	    $tag->text = $this->request->getPost('tagText');
	    $parentId = $this->request->getPost('parentId');
	    $tag->full_name = $tag->text;
		if($parentId){
			$tagModel = new TagModel();
			$parentTag = $tagModel->find($parentId);
			$tag->parent_id = $parentId ;
			$tag->full_name = $parentTag->full_name."\\" .$tag->text ;
		}

	    $tag->save();
	    return redirect()->to('/tags');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {

    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
	    $tagModel = new TagModel();
	    $tag = $tagModel->find($id);
		$tagText = $this->request->getPost('text');
		if($tag->text !== $tagText){
			$tag->text = $tagText;
			$tag->full_name = "";
		}

		$parentId = $this->request->getPost('parentId');
	    if($parentId!=$tag->parent_id){
		    $tag->parent_id = $parentId ;
		    $tag->full_name = "";
	    }

		if ($tag->full_name == ""){
			$parentTag = $tagModel->find($parentId);
			if($parentTag){
				$tag->full_name = $parentTag->full_name."\\" .$tag->text ;
			}
			else{
				$tag->full_name = $tag->text;
			}
			//create a base model set the magic get to get the id attribute automatic
			//try to move the full name functionality to entity to automatically updated when the tag updated
			//move the where function to the model
			$childrenTag = $tagModel->where("parent_id", $tag->id())->findAll();
			foreach($childrenTag as $child){
				$child->full_name = $tag->full_name."\\" .$child->text ;
				// add support to add functions on the patch
				$child->save();
			}
		}

		$tag->color = $this->request->getPost('color');
		$tag->is_context = $this->request->getPost('is_context')? 1 : 0;
		$tag->save();
	    return redirect()->to('/tags');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
	    $tagModel = new TagModel();
	    $childrenTag = $tagModel->where("parent_id", $id)->findAll();
	    foreach($childrenTag as $child){
		    $child->parent_id = 0;
			$child->full_name = $child->text;
		    // add support to add functions on the patch
		    $child->save();
	    }
	    $tagModel->delete($id);
	    return redirect()->to('/tags');
    }
}
