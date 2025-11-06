Select
[Contact ID], 
FirstName,
LastName,
Email,  
convert(date, TrialStart, 103) AS TrialStart, 
convert(date, TrialEnd, 103) AS TrialEnd, 
Subscriptionstatus,
MailingCountry,
CBSubscriptionName
from [MX01_B2C_CB_DATADESIGNER1651297796952]