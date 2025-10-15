SELECT 
AccountId as ContactKey, 
AccountEmail as Email,
[Renewal Link], 
[Renewal Product], 
AccountId, 
AccountEmail, 
AccountSite, 
AccountName, 
[Renewal Close Date]
FROM SA_RE_RO_JAN_STAGING_20240124
WHERE AccountId IS NOT NULL AND
      AccountEmail IS NOT NULL AND
      ([Renewal Link] NOT LIKE '%renewals%' OR [Renewal Link] IS NULL)