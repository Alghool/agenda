<?php

namespace App\Controllers;

use App\Entities\Diary;

class Home extends BaseController
{
    public function index(): string
    {

	    $twig = new \Alghool\Twig\Twig();
		$diaryModel = new \App\Models\DiaryModel();
	    $diaries = $diaryModel->orderBy("created_at", "DESC")->findAll();

		return $twig->render( 'homePage', ['diaries' =>$diaries] );
    }

	public function addDiary(){
		$diary = new Diary();
		$diary->text = $this->request->getPost('diaryText');
		$diary->save();
		return redirect()->to('/');
	}
}
