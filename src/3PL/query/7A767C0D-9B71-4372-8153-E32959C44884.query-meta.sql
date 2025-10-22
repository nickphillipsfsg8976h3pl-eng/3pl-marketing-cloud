SELECT DISTINCT
    o.SubscriberKey,
    MAX(o.EventDate) AS OpenDate,
    o.JobID,
    c.ContactEmail
FROM 
    [APAC Renewal Campaign_FY26_Including3E_Email3] c
LEFT JOIN 
    _Open o ON c.SubscriberKey = o.SubscriberKey
WHERE 
    (o.JobID =1276404) and o.isunique =1
GROUP BY 
    o.SubscriberKey, o.JobID, c.ContactEmail