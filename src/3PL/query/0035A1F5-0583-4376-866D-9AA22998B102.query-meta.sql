SELECT
    cs.SubscriberKey,
    cs.Email_Status,
    cs.Subscriber_Type,
    cs.receive_re_emails,
    cs.IsMstUser,
    CASE
        WHEN COALESCE(l.Email,'') = '' THEN 0
        WHEN l.Email like ('% %') THEN 0
        WHEN l.Email like ('%[%') THEN 0
        WHEN l.Email like ('%(%') THEN 0
        WHEN l.Email like ('%)%') THEN 0
        WHEN l.Email like ('%,%') THEN 0
        WHEN l.Email like ('%:%') THEN 0
        WHEN l.Email like ('%<%') THEN 0
        WHEN l.Email like ('%>%') THEN 0
        WHEN l.Email like ('%]%') THEN 0
        WHEN l.Email like ('%?%') THEN 0
        WHEN l.Email like ('%]%') THEN 0
        WHEN l.Email like ('%&%') THEN 0
        WHEN l.Email like ('%/%') THEN 0
        WHEN l.Email like ('%*%') THEN 0
        WHEN l.Email like ('%^%') THEN 0
        WHEN l.Email like ('%#%') THEN 0
        WHEN l.Email like ('%!%') THEN 0
        WHEN l.Email LIKE '%@%@%' THEN 0
        WHEN l.Email NOT LIKE '_%@_%._%' THEN 0
        ELSE 1 
    END AS IsValidEmailSyntax,
    cs.HasChannelAddress,
    cs.activated_at,
    cs.created_at,
    cs.emailable_status,
    1 AS IsConvertedLead,
    l.Email
FROM
    ENT.Contact_Summary cs INNER JOIN
    ENT.Lead_Salesforce l
        ON  cs.SubscriberKey = l.Id
WHERE
    cs.Subscriber_Type = 'Salesforce Lead'
UNION ALL
SELECT
    cs.SubscriberKey,
    cs.Email_Status,
    cs.Subscriber_Type,
    cs.receive_re_emails,
    cs.IsMstUser,
    CASE
        WHEN COALESCE(l.Email,'') = '' THEN 0
        WHEN l.Email like ('% %') THEN 0
        WHEN l.Email like ('%[%') THEN 0
        WHEN l.Email like ('%(%') THEN 0
        WHEN l.Email like ('%)%') THEN 0
        WHEN l.Email like ('%,%') THEN 0
        WHEN l.Email like ('%:%') THEN 0
        WHEN l.Email like ('%<%') THEN 0
        WHEN l.Email like ('%>%') THEN 0
        WHEN l.Email like ('%]%') THEN 0
        WHEN l.Email like ('%?%') THEN 0
        WHEN l.Email like ('%]%') THEN 0
        WHEN l.Email like ('%&%') THEN 0
        WHEN l.Email like ('%/%') THEN 0
        WHEN l.Email like ('%*%') THEN 0
        WHEN l.Email like ('%^%') THEN 0
        WHEN l.Email like ('%#%') THEN 0
        WHEN l.Email like ('%!%') THEN 0
        WHEN l.Email LIKE '%@%@%' THEN 0
        WHEN l.Email NOT LIKE '_%@_%._%' THEN 0
        ELSE 1 
    END AS IsValidEmailSyntax,
    cs.HasChannelAddress,
    cs.activated_at,
    cs.created_at,
    cs.emailable_status,
    1 AS IsConvertedLead,
    l.Email
FROM
    ENT.Contact_Summary cs INNER JOIN
    ENT.Contact_Salesforce l
        ON  cs.SubscriberKey = l.Id
WHERE
    cs.Subscriber_Type = 'Salesforce Contact'