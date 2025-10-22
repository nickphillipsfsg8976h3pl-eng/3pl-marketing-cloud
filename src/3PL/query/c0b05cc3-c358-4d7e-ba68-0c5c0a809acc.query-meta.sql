Select
[Contact ID], 
FirstName,
LastName,
Email,  
convert(datetime, TrialStart, 103) AS TrialStart,
convert(datetime, TrialEnd, 103) AS TrialEnd,
Subscriptionstatus,
MailingCountry
FROM [MXB2C_MX0008-Post-Trial_staging1651299736478]
WHERE TrialStart >= dateadd(d,-3,getdate()) AND TrialEnd < dateadd(d,-0,getdate())