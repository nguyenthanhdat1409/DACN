<?php
require_once("../includes/config.php");
require_once("../includes/classes/SearchResultProvider.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/Entity.php");
require_once("../includes/classes/PreviewProvider.php");

if (isset($_POST["term"]) && isset($_POST["username"])) {
    $term = $_POST["term"];
    $username = $_POST["username"];

    $srp = new SearchResultProvider($con, $username);
    $results = $srp->getResults($term);

    if ($results) {
        echo $results;
    } else {
        echo "<div class='no-results'>No results found.</div>";
    }
} else {
    echo "Missing term or username parameter.";
}
?>