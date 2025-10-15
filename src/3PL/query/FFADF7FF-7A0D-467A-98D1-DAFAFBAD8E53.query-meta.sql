SELECT
    c.ContactKey,
    c.SubscriptionProduct,
    c.SubscriptionRecordType,
    c.SubscriptionEndDate,
    CASE
        WHEN agg.SubscriptionStartDate IS NULL THEN 0
        WHEN DATEDIFF(day,agg.SubscriptionStartDate,c.SubscriptionStartDate) >= 7 THEN 1
        ELSE 0
    END AS ExistingAccount
FROM
    ContactsWithSubscriptions_V2 c LEFT JOIN
    (
        SELECT
            AccountId,
            MIN(SubscriptionStartDate) AS SubscriptionStartDate
        FROM
            ContactsWithSubscriptions_Staging_V1
        WHERE
            SubscriptionRecordType = 'Full'
        GROUP BY
            AccountId
    ) AS agg
        ON c.AccountId = agg.AccountId