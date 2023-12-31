<?php
class SearchResultProvider
{
    private $con, $username;
    public function __construct($con, $username)
    {
        $this->con = $con;
        $this->username = $username;
    }
    public function getResults($inputText)
    {
        $entities = EntityProvider::getSearchEntities($this->con, $inputText);
        $html = "<div class='previewCategories noScroll'></div>";
        $html .= $this->getResultHtml($entities);
        return $html . "<div></div>";
    }
    private function getResultHtml($entities)
    {
        if (sizeof($entities) == 0) {
            return;
        }
        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach ($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
            //$entitiesHtml .= "" . $entity->getName();
        }
        // return $entitiesHtml . "<br/>";
        return "<div class='category'>
            <div class='entities'>
                " . $entitiesHtml . "
            </div>
        </div>";
    }
}
