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
    o.JobID = 1216054
    AND NOT EXISTS (
        SELECT 1
        FROM BF_E5_Email_Opens de
        WHERE de.SubscriberKey = o.SubscriberKey AND de.JobID = o.JobID
    )
GROUP BY 
    o.SubscriberKey, o.JobID, c.Email
