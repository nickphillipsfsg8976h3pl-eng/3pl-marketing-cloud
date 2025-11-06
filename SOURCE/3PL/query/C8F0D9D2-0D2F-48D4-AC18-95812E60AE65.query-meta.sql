SELECT
    t.SiteCountry, 
    t.Postcode, 
    t.FirstName, 
    t.EmailAddress, 
    t.JobTitle, 
    t.AccountName
FROM [CE_SLT_MX_XmasEngagement_NB Mailer] t
WHERE t.EmailAddress NOT IN (
    SELECT c.SubscriberKey
    FROM [_Click] AS c 
    WHERE 
      c.TriggeredSendCustomerKey = '249487'
      AND c.IsUnique = 1
)
