<?php 
function linkDB () {
    $link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "micheldjoumessi-pairprog", "micheldjoumessi_pair-prog");
    if (!$link) {
        die("La connexion a échoué: " . mysqli_connect_error());
    }
    return $link;
}
?>
