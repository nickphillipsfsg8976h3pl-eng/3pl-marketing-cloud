SELECT
c.FirstName,
c.LastName,
c.Id as ContactKey,
c.Email as [EmailAddr - CRM],
s.EmailAddress as [EmailAddr - All subscribers],
GetDate() AT TIME ZONE 'Central Standard Time'
	      AT TIME ZONE 'Aus Eastern Standard Time' as LogDate
FROM ent.contact_salesforce c
INNER JOIN ent._Subscribers s ON c.Id=s.SubscriberKey
WHERE c.Email!=s.EmailAddress

UNION

SELECT
l.FirstName,
l.LastName,
l.Id as ContactKey,
l.Email as [EmailAddr - CRM],
s.EmailAddress as [EmailAddr - All subscribers],
GetDate() AT TIME ZONE 'Central Standard Time'
	      AT TIME ZONE 'Aus Eastern Standard Time' as LogDate
FROM ent.lead_salesforce l
INNER JOIN ent._Subscribers s ON l.Id=s.SubscriberKey
WHERE l.Email!=s.EmailAddress