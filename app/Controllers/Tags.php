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
		$tag->text = $this->request->getPost('text');
		$tag->full_name = $tag->text;
		$parentId = $this->request->getPost('parentId');
	    if($parentId && $parentId!=$tag->parent_id){
		    //todo solve this edge case
			$parentTag = $tagModel->find($parentId);
		    $tag->parent_id = $parentId ;
		    $tag->full_name = $parentTag->full_name."\\" .$tag->text ;
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
	    $tagModel->delete($id);
	    return redirect()->to('/tags');
    }
}
