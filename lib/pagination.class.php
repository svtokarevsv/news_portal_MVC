<?php


class Pagination
{
    public $buttons = array();

    public function __construct(Array $options = array('itemsCount' => 0, 'itemsPerPage' => 10, 'currentPage' => 1))
    {
        extract($options);

        /** @var int $currentPage */
        if (!$currentPage) {
            return;
        }

        /** @var int $pagesCount
         * @var int $itemsCount
         * @var int $itemsPerPage
         */
        $pagesCount = ceil($itemsCount / $itemsPerPage);

        if ($pagesCount == 1) {
            return;
        }

        /** @var int $currentPage */
        if ($currentPage > $pagesCount) {
            $currentPage = $pagesCount;
        }

        $this->buttons[] = new Button(1, $currentPage > 1, '<span aria-hidden="true">&laquo;</span>');
        $this->buttons[] = new Button($currentPage - 1, $currentPage > 1, '<span aria-hidden="true">&lsaquo;</span>');

        for ($i = 1; $i <= $pagesCount; $i++) {
            $active = $currentPage != $i;
            $this->buttons[] = new Button($i, $active);
        }

        $this->buttons[] = new Button($currentPage + 1, $currentPage < $pagesCount, '<span aria-hidden="true">&rsaquo;</span>');
        $this->buttons[] = new Button($pagesCount, $currentPage < $pagesCount, '<span aria-hidden="true">&raquo;</span>');
    }

    public function showPagination()
    {
        echo "<ul class=\"pagination pagination-lg\">";
        foreach ($this->buttons as $button) {
            $currentPage = isset($_GET['page']) ? (int)($_GET['page']) : 1;
            if (($button->page < $currentPage - 5) OR ($button->page > $currentPage + 5)) {
                if ($button == end($this->buttons) OR $button == reset($this->buttons)) {
                } else {
                    continue;
                }
            }
            if (!isset($_GET['page'])) {
                $page = '&page=';
                if (empty($_GET)) {
                    $page = '?page=';
                }
                $url = $_SERVER['REQUEST_URI'] . $page . $button->page;
            } else {
                $url = preg_replace("/(page=)([0-9]+)/", 'page=' . $button->page, $_SERVER['REQUEST_URI']);
            }

            if ($button->isActive) {
                echo "<li><a href='{$url} ' > {$button->text} </a></li>";
            } else {
                echo "<li><span style='color:#555555'> $button->text </span></li>";
            }

        }
        echo "</ul>";

    }

}
