SELECT 
CASE WHEN ContactKey IS NULL THEN AccountId
     WHEN ContactKey IS NOT NULL THEN ContactKey
END as ContactKey, 
FirstName, 
LastName, 
CASE WHEN Email IS NULL THEN AccountEmail
     WHEN Email IS NOT NULL THEN Email
END as Email ,
[Renewal Link], 
[Renewal Product], 
AccountId, 
AccountEmail, 
AccountSite, 
AccountName, 
[Renewal Close Date]
FROM SA_MS_RO_JAN_STAGING_20240117
WHERE [Renewal Link] NOT LIKE '%renewals%' or [Renewal Link] IS NULL