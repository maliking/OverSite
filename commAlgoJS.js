function calculateCommission() {
    var brokerFee = 0;
    var difference = 0;
    var misc = parseFloat(document.getElementById("misc").value.replace(",",""));
    var TYGross = parseFloat(document.getElementById("beg-comm").value.replace(",",""));
    var initialCommission = parseFloat(document.getElementById("gross-comm").value.replace(",",""));
    // var misc = parseFloat(document.getElementById("misc").value);
    var commission = parseFloat(document.getElementById("gross-comm").value.replace(",",""));

    var remaxFee = parseFloat(document.getElementById("remaxFee").value.replace(",",""));

    var transactionCoordFee = parseFloat(document.getElementById("trans-coor").value.replace(",",""));
    var techFee = parseFloat(document.getElementById("tech").value.replace(",",""));
    var eoInsurance = parseFloat(document.getElementById("eo_insurance").value.replace(",",""));

    if (TYGross <= 85000) {
        difference = 85000 - TYGross;
        //$total = $TYGross + $commission;
        if (commission <= difference) {
            brokerFee += commission * .20;
        }
        else {
            brokerFee += difference * .20;
            commission = commission - difference;
            if (commission > 0) {
                //$difference = 49999 - $commission;
                if (commission <= 49999) {
                    brokerFee += commission * .15;
                }
                else {
                    brokerFee += 49999 * .15;
                    commission = commission - 49999;
                    if (commission > 0) {
                        //$difference = 49999 - $commission;
                        if (commission <= 49999) {
                            brokerFee += commission * .10;
                        }
                        else {
                            brokerFee += 49999 * .10;
                            commission = commission - 49999;
                            if (commission > 0) {
                                brokerFee += commission * .05;
                            }
                        }
                    }
                }
            }
        }
    }
    else if (TYGross <= 135000) {
        difference = 135000 - TYGross;
        if (commission <= difference) {
            brokerFee += commission * .15;
        }
        else {
            brokerFee += difference * .15;
            commission = commission - difference;
            if (commission > 0) {
                if (commission <= 49999) {
                    brokerFee += commission * .10;
                }
                else {
                    brokerFee += 49999 * .10;
                    commission = commission - 49999;
                    if (commission > 0) {
                        brokerFee += commission * .05;
                    }
                }
            }
        }
    }
    else if (TYGross <= 185000) {
        difference = 185000 - TYGross;
        if (commission <= difference) {
            brokerFee += commission * .15;
        }
        else {
            brokerFee += 49999 * .10;
            commission = commission - 49999;
            if (commission > 0) {
                brokerFee += commission * .05;
            }
        }
    }
    else {
        brokerFee += commission * .05;
    }

    document.getElementById("broker").value = formatNumber(brokerFee);
    // document.getElementById("percentage").value = ;
    document.getElementById("subtotal").value = formatNumber(initialCommission - brokerFee);
    document.getElementById("agent_net").value = formatNumber(initialCommission - brokerFee  - misc - remaxFee - transactionCoordFee - techFee - eoInsurance);

    
}

function calculateCommissionFifty()
{
    var brokerFee = 0;
    var difference = 0;
    var misc = parseFloat(document.getElementById("misc").value.replace(",",""));
    var TYGross = parseFloat(document.getElementById("beg-comm").value.replace(",",""));
    var initialCommission = parseFloat(document.getElementById("gross-comm").value.replace(",",""));
    // var misc = parseFloat(document.getElementById("misc").value);
    var commission = parseFloat(document.getElementById("gross-comm").value.replace(",",""));

    var remaxFee = parseFloat(document.getElementById("remaxFee").value.replace(",",""));

    var transactionCoordFee = parseFloat(document.getElementById("trans-coor").value.replace(",",""));
    var techFee = parseFloat(document.getElementById("tech").value.replace(",",""));
    var eoInsurance = parseFloat(document.getElementById("eo_insurance").value.replace(",",""));

    brokerFee = initialCommission/2;


    document.getElementById("broker").value = formatNumber(brokerFee);
    // document.getElementById("percentage").value = ;
    document.getElementById("subtotal").value = formatNumber(initialCommission - brokerFee);
    document.getElementById("agent_net").value = formatNumber(initialCommission - brokerFee - transactionCoordFee - techFee - eoInsurance - misc - remaxFee);


}
function formatNumber (num) 
{
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    }