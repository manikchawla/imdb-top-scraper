<?php
if ($argc != 2) {
    echo "Invalid number of arguments.";
    exit();
}
$user_input = $argv[1];
if (preg_match('/^[A-Z]$/', $user_input))
    $result = letter_to_number(ord($user_input) - 64);
else if (preg_match('/^[0-9]+$/', $user_input))
    $result = is_numeric(number_to_letter($user_input)) ? chr(64 + number_to_letter($user_input)) : number_to_letter($user_input);
else 
    $result = "Please enter an uppercase letter or number.";
  
echo $result;

function letter_to_number($n) {
    if ($n== 1)
        return 1;
    else
        return letter_to_number($n-1) * 2 + $n;
}

function number_to_letter($n) {
    for ($i = 1; $i <= 26; $i++) {
        $answer = letter_to_number($i);
        if ($answer == $n)
            return $i;
    }
    $i = "This number doesn't occur in the series.";
    return $i;
}
   
?> 