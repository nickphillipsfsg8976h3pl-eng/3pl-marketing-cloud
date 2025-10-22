SELECT
    c.ContactKey,
    c.SubscriptionProduct,
    CASE
        WHEN agg.SubscriptionStartDate IS NULL THEN 0
        WHEN DATEDIFF(day,agg.SubscriptionStartDate,c.SubscriptionStartDate) >= 7 THEN 1
        ELSE 0
    END AS ExistingAccount
FROM
    ContactsWithSubscriptions c LEFT JOIN
    (
        SELECT
            AccountId,
            MIN(SubscriptionStartDate) AS SubscriptionStartDate
        FROM
            ContactsWithSubscriptions_Staging
        WHERE
            SubscriptionRecordType = 'Full'
        GROUP BY
            AccountId
    ) AS agg
        ON c.AccountId = agg.AccountId