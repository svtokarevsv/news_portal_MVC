<?php

class NewsController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new NewsModel();
    }
    public function category()
    {
        $this->data['category']= $this->model->getNewsByCategoryID($this->model->extractId($this->params[0]));
        $this->data['pagination']=$this->model->getPagination();
    }
    public function article()
    {
        $id=(int)$this->model->extractId($this->params[0]);
        $this->data['article']= $this->model->getArticleByID($id);
        $this->data['comments']= $this->model->getCommentsByID($id);
        $this->data['current_views']=rand(1,5);
        $this->model->updateViewsById($this->data['current_views'],$id);

        if(!empty($_POST['like']) OR !empty($_POST['dislike'])){
            $this->model->updateLikes($_POST);
            Router::redirect($_SERVER['REQUEST_URI']);
        }
    }
   
}