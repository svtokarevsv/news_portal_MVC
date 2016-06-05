<?php

class SearchModel extends Model
{

    public function getNewsByTag($tag)
    {
        $tag = $this->db->escape($tag);
        $sql = "select n.id,n.title,s.title as category FROM news n 
                JOIN news_has_tags nht
                ON n.id = nht.news_id
                JOIN tags t
                ON nht.tags_id = t.id
                JOIN news_has_sections nhs
                on n.id=nhs.news_id
                JOIN sections s 
                ON nhs.sections_id = s.id                
                WHERE t.tag='{$tag}'";

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

    public function getTagList()
    {
        $sql = "SELECT * FROM tags";
        return $this->db->query($sql);
    }

    public function getCategoriesList()
    {
        $sql = "SELECT * FROM sections";
        return $this->db->query($sql);
    }

    public function getNews($adId = false)
    {

        $sql = "SELECT n.*,s.title as category FROM news n 
                JOIN news_has_tags nht
                ON n.id = nht.news_id
                JOIN news_has_sections nhs
                ON n.id = nhs.news_id
                JOIN sections s 
                ON nhs.sections_id = s.id
                WHERE 1";
        if (!empty($_GET['search'])) {
            $search = $this->db->escape($_GET['search']);
            $sql .= " and n.title LIKE '%{$search}%'";
            if (!empty($_GET['description_search']) AND $_GET['description_search'] == "on") {
                $sql .= " OR n.text LIKE '%{$search}%'";
            }
        }
        if (!empty($_GET['tags'])) {
            $tag = intval($_GET['tags']);
            $sql .= " and nht.tags_id ={$tag}";
        }
        if (!empty($_GET['category'])) {
            $category = intval($_GET['category']);
            $sql .= " and nhs.sections_id ={$category}";
        }
        if (!empty($_GET['date_from']) || !empty($_GET['date_to'])) {
            $from = "1981-06-10";
            $to = "2026-06-10";
            if (!empty($_GET['date_from'])) {
                $from = $this->db->escape($_GET['date_from']);
            }
            if (!empty($_GET['date_to'])) {
                $to = $this->db->escape($_GET['date_to']);
            }
            $sql .= " and n.date BETWEEN '{$from}' AND '{$to}'";
        }
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