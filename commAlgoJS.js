function calculateCommission()
{
  var brokerFee = 0;
  var difference = 0;
  var TYGross = parseFloat(document.getElementById("beg-comm").value);
  var initialCommission = parseFloat(document.getElementById("gross-comm").value);
  var misc = parseFloat(document.getElementById("misc").value);
  var commission = parseFloat(document.getElementById("gross-comm").value);


  if(TYGross <= 80000)
        {
          difference =  80000 - TYGross;
          //$total = $TYGross + $commission;
          if(commission <= difference)
          {
            brokerFee += commission * .20;
          }
          else
          {
            brokerFee += difference * .20;
            commission = commission - difference;
            if(commission > 0)
            {
              //$difference = 49999 - $commission;
              if(commission <= 49999)
              {
                brokerFee += commission * .15;
              }
              else
              {
                brokerFee += 49999 * .15;
                commission = commission - 49999;
                if(commission > 0)
                {
                  //$difference = 49999 - $commission;
                  if(commission <= 49999)
                  {
                    brokerFee += commission * .10;
                  }
                  else
                  {
                    brokerFee += 49999 * .10;
                    commission = commission - 49999;
                    if(commission > 0)
                    {
                      brokerFee += commission * .5;
                    }
                  }
                }
              }
            }
          }
        }
        else if (TYGross <= 130000)
        {
          difference =  130000 - TYGross; 
          if(commission <= difference)
          {
            brokerFee += commission * .15;
          }
          else
          {
            brokerFee += difference * .15;
            commission = commission - difference;
            if(commission > 0)
            {
              if(commission <= 49999)
              {
                brokerFee += commission * .10;
              }
              else
              {
                brokerFee += 49999 * .10;
                commission = commission - 49999;
                if(commission > 0)
                {
                  brokerFee += commission * .5;
                }
              }
            }
          }
        }
        else if(TYGross <= 180000)
        {
          difference =  180000 - TYGross; 
          if(commission <= difference)
          {
            brokerFee += commission * .15;
          }
          else
          {
            brokerFee += 49999 * .10;
            commission = commission - 49999;
            if(commission > 0)
            {
              brokerFee += commission * .5;
            }
          }
        }
        else
        {
          brokerFee += commission * .5;
        }

        document.getElementById("broker").value = brokerFee;
        document.getElementById("subtotal").value = initialCommission - brokerFee;
        document.getElementById("agent_net").value = initialCommission - brokerFee - 349 - misc;


}