<?php

include('/Users/kristofferrisa/Source/git-repos/WEB1000-Exam/vedlikehold/php/AdminClasses.php');

$data = new Airport();

$dataset = $data->ShowAllAirportsDataset();

print_r($dataset);

$last = count($dataset) - 1;

foreach ($dataset as $i => $row)
{
    $isFirst = ($i == 0);
    $isLast = ($i == $last);

    echo '<p> ' . $row[3] .' '. $row[1] .'</p>';
}

?>