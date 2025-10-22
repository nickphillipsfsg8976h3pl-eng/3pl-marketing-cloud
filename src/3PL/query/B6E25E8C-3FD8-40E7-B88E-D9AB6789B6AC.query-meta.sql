SELECT
    t.SiteCountry, 
    t.Postcode, 
    t.FirstName, 
    t.EmailAddress, 
    t.JobTitle, 
    t.AccountName
FROM [CE_CT_MX_XmasEngagement_NB Mailer] t
WHERE t.EmailAddress NOT IN (
    SELECT c.SubscriberKey
    FROM [_Click] AS c 
    WHERE 
      c.TriggeredSendCustomerKey = '249486'
      AND c.IsUnique = 1
)
