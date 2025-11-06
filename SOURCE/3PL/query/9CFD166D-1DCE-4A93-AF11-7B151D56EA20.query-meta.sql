SELECT
    t.SiteCountry, 
    t.Postcode, 
    t.FirstName, 
    t.LastName, 
    t.EmailAddress, 
    t.JobTitle, 
    t.AccountName
FROM [CE SLT_RE_XmasEngagement_NB Mailer] t
WHERE t.EmailAddress NOT IN (
    SELECT c.SubscriberKey
    FROM [_Click] AS c 
    WHERE 
      c.TriggeredSendCustomerKey = '249979'
      AND c.IsUnique = 1
)
