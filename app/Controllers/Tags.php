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

	    return $twig->render( 'tagPage', ['tags' =>$tags, 'tag' => $tagModel->find($id)] );
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
        //
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
        //
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
