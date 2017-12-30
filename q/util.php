<?php

function calculateSupply($reward) {
    // BaseReward = (MSupply - Supply)/2^EmissionSpeedFactor
    // EmissionSpeedFactor = 18
    $rewardF = floatval($reward);
    $mSupply = 18446744073709551616; // max supply is 2^64 - https://github.com/cryptonotefoundation/cryptonote#second-step-emission-logic
    $divisor = 262144; //2^18
    $supply = $mSupply - ($rewardF * $divisor);
    return $supply;
}

?>