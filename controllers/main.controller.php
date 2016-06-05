<?php

class MainController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new MainModel();
    }
    public function index()
    {
        $this->data['slider']= $this->model->sliderList();
        $this->data['top-commentator']= $this->model->commentatorList();
        $this->data['top-news']= $this->model->topNews();
        $this->data['all-news']= $this->model->AllNews();
    }

    public function default_data()
    {
        $this->data['top-two-advertisements']= $this->model->topTwoAdv();
        $this->data['advertisements']= $this->model->advertisements();
        $this->data['tags']=$this->model->getTagList();
    }

    public function ajax_adv()
    {
        $this->model->adv_click($_POST);
        
    }
}