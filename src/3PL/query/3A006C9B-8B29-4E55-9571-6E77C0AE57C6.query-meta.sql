SELECT DISTINCT
    o.SubscriberKey,
    MAX(o.EventDate) AS OpenDate,
    o.JobID,
    c.Email
FROM 
    ent.Contact_Salesforce c
LEFT JOIN 
    _Open o ON c._ContactKey = o.SubscriberKey
WHERE 
    o.JobID IN (1216054, 1216053)
GROUP BY 
    o.SubscriberKey, o.JobID, c.Email