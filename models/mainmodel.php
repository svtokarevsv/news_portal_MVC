<?php

class MainModel extends Model
{
    
    public function sliderList()
    {
        $sql = "select n.id,n.title,ni.image from news n 
                JOIN news_images ni 
                ON n.id=ni.id_news
                where 1 ORDER BY id DESC limit 4";
        
        return $this->db->query($sql);
    }
    public function commentatorList()
    {
        $sql = "SELECT c.id_user, COUNT(c.id) as counts,u.name  FROM `comments` c 
                JOIN users u 
                ON c.id_user=u.id
                GROUP BY id_user ORDER BY counts DESC limit 5";

        return $this->db->query($sql);
    }
    public function topNews()
    {
        $sql = "SELECT c.id_news, COUNT(c.id) as counts,n.title  FROM `comments` c 
                JOIN news n 
                ON c.id_news=n.id
                GROUP BY id_news ORDER BY counts DESC limit 5";

        return $this->db->query($sql);
    }
    public function AllNews()
    {
        $i=0;
        $data=array();

        $sql="select count(id) from sections";
        $i=(int)$this->db->query($sql)[0]["count(id)"];
        for ($j=1;$j<=$i;$j++){
        $sql = "select nhs.news_id,s.title as category,s.id,n.title,n.date from news_has_sections nhs
                JOIN news n
                ON nhs.news_id=n.id
                JOIN sections s 
                on nhs.sections_id = s.id
                WHERE nhs.sections_id={$j} ORDER BY n.date DESC LIMIT 5
                ";
          $data[$j]=  $this->db->query($sql);
        }
        return $data;
    }

    public function topTwoAdv()
    {
        $sql = "SELECT * FROM advertisement
               ORDER BY click_count DESC limit 2";
        return $this->db->query($sql);
    }
    public function advertisements()
    {
        $sql = "SELECT * FROM advertisement ORDER BY RAND() DESC limit 6";
        return $this->db->query($sql);
    }

    public function getTagList()
    {
        $sql="SELECT * FROM tags";
        return $this->db->query($sql);
    }

    public function adv_click($array)
    {
        $sql="UPDATE `advertisement` SET `click_count`=`click_count`+1 WHERE id={$array['id']}";

        return $this->db->query($sql);
    }
   
}
