Select
bc.[Contact ID], 
bc.FirstName,
bc.Email,  
bc.LastName, 
bc.TrialStart, 
bc.TrialEnd, 
bc.Subscriptionstatus,
bc.CBSubscriptionName,
bc.MailingCountry
from [MX01_B2C_CB_DATADESIGNER1651296586528] bc
where convert(varchar(10), TrialStart, 103) 
    = convert(varchar(10), getdate(), 103)