<?php

class UserModel extends Model
{
    
    public function getCommentsByUserID($user_id)
    {
        $sql = "select c.*,n.title,n.id as id_news,u.name FROM comments c 
                JOIN news n 
                ON c.id_news = n.id 
                JOIN users u 
                ON c.id_user=u.id
                WHERE c.id_user={$user_id}";
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

    public function updateLikes(array $array)
    {

        isset($array['like'])?$sql="UPDATE `comments` SET `likes`=likes+1 WHERE id={$_POST['comment_id']}":null;
        isset($array['dislike'])?$sql="UPDATE `comments` SET `dislikes`=dislikes+1 WHERE id={$_POST['comment_id']}":null;
        $this->db->query($sql);
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
}
