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
    x.ContactLastModifiedDate,
    x.ContactJobFunction,
    x.ContactStatus,
    x.ContactRoles,
    x.ContactTerritory,
    x.ContactSalutation,
    x.ContactProductInfluencer,
    x.ContactMarketingInterest,
    x.ContactMarketingProductInterest,
    x.ContactRecordTypeID,

    x.AccountId,
    x.AccountName,
    x.AccountGlobalSchoolCategory,
    x.AccountLocalAuthority,
    x.AccountOwnerId,
    x.AccountBillingStreet,
    x.AccountBillingCity,
    x.AccountBillingState,
    x.AccountBillingStateCode,
    x.AccountBillingPostalCode,
    x.AccountBillingCountry,
    x.AccountBillingCountryCode,
    x.AccountStatus,

    x.ContractId,
    x.ContractStartDate,
    x.ContractEndDate,
    x.ContractMultiYearExpiration,
    x.OpportunityId,
    x.QuoteId,
    x.RenewalOpportunityId,

    x.OpportunityType,
    x.OpportunityStage,
    x.OpportunityOwnerId,
    x.OpportunityOwnerRole,
    x.OpportunityConverted,
    x.OpportunityWonLostReason,
    x.OpportunityOppStageBeforeLost,
    x.OpportunityIsClosed,
    x.OpportunityIsWon,

    x.OwnerEmail,
    x.OwnerFirstName,
    x.OwnerLastName,

    x.SubscriptionStartDate,
    agg.SubscriptionCapacity,
    x.SubscriptionExpired,
    x.SubscriptionStatus,
    x.SubscriptionTerritory,
    x.SubscriptionQuantity,
    x.SubscriptionType,
    
    LEFT(STUFF(
         (SELECT ', ' + SubscriptionProduct
          FROM ContactsWithSubscriptions_V1
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
            ContactLastModifiedDate,
            ContactJobFunction,
            ContactStatus,
            ContactRoles,
            ContactTerritory,
            ContactSalutation,
            ContactProductInfluencer,
            ContactMarketingInterest,
            ContactMarketingProductInterest,
            ContactRecordTypeID,

            AccountId,
            AccountName,
            AccountGlobalSchoolCategory,
            AccountLocalAuthority,
            AccountOwnerId,
            AccountBillingStreet,
            AccountBillingCity,
            AccountBillingState,
            AccountBillingStateCode,
            AccountBillingPostalCode,
            AccountBillingCountry,
            AccountBillingCountryCode,
            AccountStatus,
            ContractId,
            ContractStartDate,
            ContractEndDate,
            ContractMultiYearExpiration,
            OpportunityId,
            QuoteId,
            RenewalOpportunityId,
            OpportunityType,
            OpportunityStage,
            OpportunityOwnerId,
            OpportunityOwnerRole,
            OpportunityConverted,
            OpportunityWonLostReason,
            OpportunityOppStageBeforeLost,
            OpportunityIsClosed,
            OpportunityIsWon,
            OwnerEmail,
            OwnerFirstName,
            OwnerLastName,

            SubscriptionStartDate,
            SubscriptionCapacity,
            SubscriptionExpired,
            SubscriptionStatus,
            SubscriptionTerritory,
            SubscriptionQuantity,
            SubscriptionType
        FROM
            ContactsWithSubscriptions_Staging_V1
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
            ContactsWithSubscriptions_Staging_V1
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