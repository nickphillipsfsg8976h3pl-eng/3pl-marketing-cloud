SELECT
    x.SubscriberKey,
    1 AS DuplicateCRMContact
FROM
    (
        SELECT
            ROW_NUMBER() OVER(PARTITION BY EmailAddress ORDER BY SubscriberType ASC, CreatedDate ASC) AS RowNumber,
            SubscriberKey
        FROM
            ContactSummary cs
        WHERE
            EmailAddress IS NOT NULL AND
            SubscriberType LIKE ('Salesforce %')    
    ) AS x
WHERE
    x.RowNumber > 1