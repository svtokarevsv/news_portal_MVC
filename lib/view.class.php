<?php

class View
{
    protected $data;
    protected $path;
    protected static function getDefaultViewPath()
    {
        $router=App::getRouter();
        if(!$router){
            return false;
        }
        $controller_dir= $router->getController();
        $template_name=$router->getMethodPrefix().$router->getAction().'.html';
        return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
    }

    public function __construct($data=array(),$path=null)
    {

        if(!$path){

            $path=self::getDefaultViewPath();


        }

        if(!file_exists($path)){
            throw new Exception("Template file is not found in path: ".$path);
        }
        $this->path=$path;
        $this->data=$data;
    }
    public static function NormalizeStringToLatin( $s ) {
        $lang2tr = array(
            // russian
            'й'=>'j','ц'=>'c','у'=>'u','к'=>'k','е'=>'e','н'=>'n','г'=>'g','ш'=>'sh',
            'щ'=>'sh','з'=>'z','х'=>'h','ъ'=>'','ф'=>'f','ы'=>'y','в'=>'v','а'=>'a',
            'п'=>'p','р'=>'r','о'=>'o','л'=>'l','д'=>'d','ж'=>'zh','э'=>'e','я'=>'ja',
            'ч'=>'ch','с'=>'s','м'=>'m','и'=>'i','т'=>'t','ь'=>'','б'=>'b','ю'=>'ju','ё'=>'e','и'=>'i',

            'Й'=>'J','Ц'=>'C','У'=>'U','К'=>'K','Е'=>'E','Н'=>'N','Г'=>'G','Ш'=>'SH',
            'Щ'=>'SH','З'=>'Z','Х'=>'H','Ъ'=>'','Ф'=>'F','Ы'=>'Y','В'=>'V','А'=>'A',
            'П'=>'P','Р'=>'R','О'=>'O','Л'=>'L','Д'=>'D','Ж'=>'ZH','Э'=>'E','Я'=>'JA',
            'Ч'=>'CH','С'=>'S','М'=>'M','И'=>'I','Т'=>'T','Ь'=>'','Б'=>'B','Ю'=>'JU','Ё'=>'E','И'=>'I',
            // czech
            'á'=>'a', 'ä'=>'a', 'ć'=>'c', 'č'=>'c', 'ď'=>'d', 'é'=>'e', 'ě'=>'e',
            'ë'=>'e', 'í'=>'i', 'ň'=>'n', 'ń'=>'n', 'ó'=>'o', 'ö'=>'o', 'ŕ'=>'r',
            'ř'=>'r', 'š'=>'s', 'Š'=>'S', 'ť'=>'t', 'ú'=>'u', 'ů'=>'u', 'ü'=>'u',
            'ý'=>'y', 'ź'=>'z', 'ž'=>'z',

            'і'=>'i', 'ї' => 'i', 'b' => 'b', 'І' => 'i',
            // special
            ' '=>'-', '\''=>'', '"'=>'', '\t'=>'', '«'=>'', '»'=>'', '?'=>'', '!'=>'', '*'=>''
        );
        $string = preg_replace( '/[\-]+/', '-', preg_replace( '/[^\w\-\*]/', '', strtolower( strtr( $s, $lang2tr ) ) ) );
        //echo $url."<br>";
        return  $string;
    }
    public function render(){
        in_array('content', $this->data)?$data=$this->data['data']:$data=$this->data;
        ob_start();
        include ($this->path);
        $content=ob_get_clean();

        return $content;
    }
}