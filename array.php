<?php
    echo "Input array= [1, 5, 4, 2] <br>";
    echo "Max value of the array element is: 5 <br>";
    $inputArrayElement = [1, 5, 4, 2];
    $compareArrayElement = [1, 2, 3, 4, 5];
    $missingElement = null;
    foreach ($compareArrayElement as $compareElement) {
        $found = false;
            
        foreach ($inputArrayElement as $element) {
            if ($compareElement == $element) {
                $found = true;
                break;
            } 
        }
        if (!$found) {
            $missingElement = $compareElement;
        }
    }

    echo "The missing array element is: " . $missingElement;
?>