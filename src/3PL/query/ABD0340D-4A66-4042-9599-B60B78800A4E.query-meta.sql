SELECT
    x.SubscriberKey,
    x.Subscriber_Type,
    x.JobID,
    x.AccountID
FROM
    (
        SELECT
            ROW_NUMBER() OVER(PARTITION BY cs.SubscriberKey ORDER BY s.EventDate DESC) AS RowNumber,
            cs.SubscriberKey,
            cs.Subscriber_Type,
            s.JobID,
            s.AccountID
        FROM
            ENT.Contact_Summary cs INNER JOIN
            _Sent s
                ON  cs.SubscriberKey = s.SubscriberKey
        WHERE
            cs.Subscriber_Type NOT IN ('Salesforce Contact','Salesforce Lead','Salesforce Object','BEL Contact','REBC Contact','RE Contact','april22 Contact')
    ) AS x
WHERE
    x.RowNumber = 1