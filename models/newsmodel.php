<?php

class NewsModel extends Model
{
    
    public function getNewsByCategoryID($id)
    {
        $sql = "select n.id,n.title,s.title as category from news n 
                JOIN news_has_sections nhs 
                ON n.id = nhs.news_id
                JOIN sections s 
                on nhs.sections_id = s.id
                WHERE s.id={$id} ORDER BY n.date DESC";
        $this->affected_rows = $this->db->getAffectedRows($sql);//получаем общее количество записей без ЛИМИТа для пагинации
        if (!empty($_GET['page'])) {
            $page = (int)$_GET['page'] - 1;
        } else {
            $page = 0;
        }
        $perPage = Config::get('perPage');
        $start = $page * $perPage;
        $sql .= " LIMIT {$start}, {$perPage}";
        return $this->db->query($sql);
    }
       public function getArticleByID($id)
    {
        $sql = "select n.id,n.title,n.text,n.views,s.title as category,s.id as section_id ,t.tag,ni.image from news n 
                JOIN news_has_sections nhs 
                ON n.id = nhs.news_id
                JOIN sections s 
                on nhs.sections_id = s.id
                JOIN news_images ni 
                ON n.id=ni.id_news
                LEFT JOIN news_has_tags nht
                ON n.id = nht.news_id
                LEFT JOIN tags t 
                ON t.id=nht.tags_id
                WHERE n.id={$id} GROUP BY t.tag";
//        die($sql);
        return $this->db->query($sql);
    }
    public function getCommentsByID($id)
    {
        $sql = "select c.*,u.name,u.id as user_id FROM comments c 
                JOIN users u 
                ON c.id_user=u.id
                WHERE id_news={$id} ORDER by c.likes DESC ";
        return $this->db->query($sql);
    }
    public function updateViewsById($views,$id)
    {
        $views=(int)$views;
        $sql="UPDATE `news` SET `views`=views+{$views} WHERE id={$id}";
        return $this->db->query($sql);
    }
    
    public function getPagination()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        return new Pagination(array(
            'itemsCount' => $this->getAffectedRows(),
            'itemsPerPage' => Config::get('perPage'),
            'currentPage' => $page
        ));
    }

    public function updateLikes(array $array)
    {
        
        isset($array['like'])?$sql="UPDATE `comments` SET `likes`=likes+1 WHERE id={$_POST['comment_id']}":null;
        isset($array['dislike'])?$sql="UPDATE `comments` SET `dislikes`=dislikes+1 WHERE id={$_POST['comment_id']}":null;
        $this->db->query($sql);
    }
   
}