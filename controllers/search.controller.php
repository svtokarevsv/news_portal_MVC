<?php

class SearchController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new SearchModel();
    }
    public function tag()
    {
        if(!empty($_POST['tag']))Router::redirect(PRELINK."search/tag/".$_POST['tag']);
        $tag=$this->params[0];
        $this->data['tag']=htmlspecialchars(trim($tag));
        $this->data['news']= $this->model->getNewsByTag($tag);
        $this->data['pagination']=$this->model->getPagination();
    }

    public function result()
    {
        $this->data['tags']=$this->model->getTagList();
        $this->data['categories']=$this->model->getCategoriesList();
        !empty($_GET)?$this->data['result_news']=$this->model->getNews():null;
        $this->data['pagination']=$this->model->getPagination();
    }
}