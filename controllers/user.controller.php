<?php

class UserController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new UserModel();
    }
    public function comments()
    {
        $id=(int)$this->model->extractId($this->params[0]);
        $this->data['comments']= $this->model->getCommentsByUserID($id);
        $this->data['pagination']=$this->model->getPagination();
        if(!empty($_POST['like']) OR !empty($_POST['dislike'])){
            $this->model->updateLikes($_POST);
            Router::redirect($_SERVER['REQUEST_URI']);
        }
    }

}