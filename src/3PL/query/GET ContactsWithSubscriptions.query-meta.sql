SELECT
    x.ContactKey,
    x.SubscriptionProduct,
    x.SubscriptionRecordType,
    x.SubscriptionEndDate,
    x.SubscriptionId,
    x.ContactTitle,
    x.ContactFirstName,
    x.ContactLastName,
    x.ContactEmail,
    x.ContactMobilePhone,
    x.ContactLocale,
    x.HasOptedOutOfEmail,
    x.ContactCreateDate,
    x.BillingCountry,
    x.BillingCountryCode,
    x.BillingStateCode,
    x.ContactJobFunction,
    x.ContactStatus,
    x.ContactRoles,
    x.AccountId,
    x.AccountName,
    x.ContractStartDate,
    x.ContractEndDate,
    x.ContractMultiYearExpiration,
    x.OpportunityId,
    x.QuoteId,
    x.RenewalOpportunityId,
    x.SubscriptionStartDate,
    agg.SubscriptionCapacity,
    x.SubscriptionExpired,
    x.SubscriptionStatus,
    x.SubscriptionTerritory,
    x.OpportunityType,
    x.OpportunityStage,
    x.OpportunityOwnerId,
    x.OpportunityOwnerRole,
    x.OwnerEmail,
    x.OwnerFirstName,
    x.OwnerLastName,
    LEFT(STUFF(
         (SELECT ', ' + SubscriptionProduct
          FROM ContactsWithSubscriptions
          WHERE
            ContactKey = x.ContactKey AND
            SubscriptionEndDate > GETDATE()
          FOR XML PATH (''))
          , 1, 1, ''),95)  AS ActiveFullSubscriptions
FROM
    (
        SELECT
            ContactKey,
            SubscriptionProduct,
            SubscriptionRecordType,
            SubscriptionEndDate,
            ROW_NUMBER() OVER(PARTITION BY ContactKey, SubscriptionProduct ORDER BY SubscriptionEndDate DESC) AS RowNumber,
            SubscriptionId,
            ContactTitle,
            ContactFirstName,
            ContactLastName,
            ContactEmail,
            ContactMobilePhone,
            ContactLocale,
            HasOptedOutOfEmail,
            ContactCreateDate,
            BillingCountry,
            BillingCountryCode,
            BillingStateCode,
            ContactJobFunction,
            ContactStatus,
            ContactRoles,
            AccountId,
            AccountName,
            ContractStartDate,
            ContractEndDate,
            ContractMultiYearExpiration,
            OpportunityId,
            QuoteId,
            RenewalOpportunityId,
            SubscriptionStartDate,
            SubscriptionExpired,
            SubscriptionStatus,
            SubscriptionTerritory,
            OpportunityType,
            OpportunityStage,
            OpportunityOwnerId,
            OpportunityOwnerRole,
            OwnerEmail,
            OwnerFirstName,
            OwnerLastName
        FROM
            ContactsWithSubscriptions_Staging
        WHERE
            RowNumber = 1
    ) AS x INNER JOIN
    (
        SELECT
            ContactKey,
            SubscriptionProduct,
            SubscriptionEndDate,
            CONVERT(INT,SUM(SubscriptionCapacity)) AS SubscriptionCapacity
        FROM
            ContactsWithSubscriptions_Staging
        GROUP BY
            ContactKey,
            SubscriptionProduct,
            SubscriptionEndDate
    ) agg
        ON  x.ContactKey = agg.ContactKey AND
            x.SubscriptionProduct = agg.SubscriptionProduct AND
            x.SubscriptionEndDate = agg.SubscriptionEndDate 
WHERE
    x.RowNumber = 1