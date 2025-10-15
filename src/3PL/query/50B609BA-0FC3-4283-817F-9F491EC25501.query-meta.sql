SELECT
    t.SiteCountry, 
    t.Postcode, 
    t.FirstName, 
    t.LastName, 
    t.EmailAddress, 
    t.JobTitle, 
    t.AccountName
FROM [CE CT_RE_XmasEngagement_NB Mailer] t
WHERE t.EmailAddress NOT IN (
    SELECT c.SubscriberKey
    FROM [_Click] AS c 
    WHERE 
      c.TriggeredSendCustomerKey = '249978'
      AND c.IsUnique = 1
)
