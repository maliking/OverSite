<?php

function potentialAlgo($tyGross, $listingTotal)
{
	
	$potenGross = 0;
	$difference = 0;
	$tyG = $tyGross;
	$listingT = $listingTotal;

	if ($tyG <= 85000) {
        $difference = 80000 - $tyG;
        //$total = $$tyG + $$listingT;
        if ($listingT <= $difference) {
            $potenGross += $listingT * .80;
        }
        else {
            $potenGross += $difference * .80;
            $listingT = $listingT - $difference;
            if ($listingT > 0) {
                //$$difference = 49999 - $$listingT;
                if ($listingT <= 49999) {
                    $potenGross += $listingT * .85;
                }
                else {
                    $potenGross += 49999 * .85;
                    $listingT = $listingT - 49999;
                    if ($listingT > 0) {
                        //$$difference = 49999 - $$listingT;
                        if ($listingT <= 49999) {
                            $potenGross += $listingT * .90;
                        }
                        else {
                            $potenGross += 49999 * .90;
                            $listingT = $listingT - 49999;
                            if ($listingT > 0) {
                                $potenGross += $listingT * .95;
                            }
                        }
                    }
                }
            }
        }
    }
    else if ($tyG <= 135000) {
        $difference = 130000 - $tyG;
        if ($listingT <= $difference) {
            $potenGross += $listingT * .85;
        }
        else {
            $potenGross += $difference * .85;
            $listingT = $listingT - $difference;
            if ($listingT > 0) {
                if ($listingT <= 49999) {
                    $potenGross += $listingT * .90;
                }
                else {
                    $potenGross += 49999 * .90;
                    $listingT = $listingT - 49999;
                    if ($listingT > 0) {
                        $potenGross += $listingT * .95;
                    }
                }
            }
        }
    }
    else if ($tyG <= 185000) {
        $difference = 180000 - $tyG;
        if ($listingT <= $difference) {
            $potenGross += $listingT * .85;
        }
        else {
            $potenGross += 49999 * .90;
            $listingT = $listingT - 49999;
            if ($listingT > 0) {
                $potenGross += $listingT * .95;
            }
        }
    }
    else {
        $potenGross += $listingT * .95;
    }
	
return $potenGross;

}

?>