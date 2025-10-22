SELECT 
    o.SubscriberKey,
    MAX(o.EventDate) AS OpenDate,
    o.JobID,
    c.Email
FROM 
    ent.Contact_Salesforce c
LEFT JOIN 
    _Open o ON c._ContactKey = o.SubscriberKey
WHERE 
    o.JobID = 1239122
    AND NOT EXISTS (
        SELECT 1
        FROM GLOBAL_BTS_NY_DNO_E2 de
        WHERE de.SubscriberKey = o.SubscriberKey AND de.JobID = o.JobID
    )
GROUP BY 
    o.SubscriberKey, o.JobID, c.Email
