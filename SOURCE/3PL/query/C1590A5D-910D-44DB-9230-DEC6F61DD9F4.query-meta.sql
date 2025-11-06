SELECT cws.ContactKey,
    cws.SubscriptionProduct,
    cws.SubscriptionRecordType,
    cws.SubscriptionEndDate,
    cws.SubscriptionId,

    cws.ContactTitle,
    cws.ContactFirstName,
    cws.ContactLastName,
    cws.ContactEmail,
    cws.ContactMobilePhone,
    cws.ContactLocale,
    cws.HasOptedOutOfEmail,
    cws.ContactCreateDate,
    cws.ContactLastModifiedDate,
    cws.ContactJobFunction,
    cws.ContactStatus,
    cws.ContactRoles,
    cws.ContactTerritory,
    cws.ContactSalutation,
    cws.ContactProductInfluencer,
    cws.ContactMarketingInterest,
    cws.ContactMarketingProductInterest,
    cws.ContactRecordTypeID,

    cws.AccountId,
    cws.AccountName,
    cws.AccountGlobalSchoolCategory,
    cws.AccountLocalAuthority,
    cws.AccountOwnerId,
    cws.AccountBillingStreet,
    cws.AccountBillingCity,
    cws.AccountBillingState,
    cws.AccountBillingStateCode,
    cws.AccountBillingPostalCode,
    cws.AccountBillingCountry,
    cws.AccountBillingCountryCode,
    cws.AccountStatus,

    cws.ContractId,
    cws.ContractStartDate,
    cws.ContractEndDate,
    cws.ContractMultiYearExpiration,
    cws.OpportunityId,
    cws.QuoteId,
    cws.RenewalOpportunityId,

    cws.OpportunityType,
    cws.OpportunityStage,
    cws.OpportunityOwnerId,
    cws.OpportunityOwnerRole,
    cws.OpportunityConverted,
    cws.OpportunityWonLostReason,
    cws.OpportunityOppStageBeforeLost,
    cws.OpportunityIsClosed,
    cws.OpportunityIsWon,

    cws.OwnerEmail,
    cws.OwnerFirstName,
    cws.OwnerLastName,

    cws.SubscriptionStartDate,
    cws.SubscriptionCapacity,
    cws.SubscriptionExpired,
    cws.SubscriptionStatus,
    cws.SubscriptionTerritory,
    cws.SubscriptionQuantity,
    cws.SubscriptionType,
    cws.ExistingAccount,
    cws.ActiveFullSubscriptions,
    c.MX_Grade_Level__c,
    c.Students_in_MX_Class__c,
    c.Last_Mathletics_Active_Date__c,
    c.RE_Grade_Level__c,
    c.Students_in_RE_Class__c,
    c.Last_ReadingEggs_Active_Date__c,
    c.MS_Grade_Level__c,
    c.Students_in_MS_Class__c,
    c.Last_Mathseeds_Active_Date__c,
    a.Clever_MSDS_Sync__c AS [Clever Managed],
    a.Account_Segment__c,
    a.Mathletics_Product_Usage__c,
    CASE
        WHEN a.Mathletics_Product_Usage__c > 75 THEN 'green'
        WHEN a.Mathletics_Product_Usage__c > 25 THEN 'yellow'
        WHEN a.Mathletics_Product_Usage__c > 0 THEN 'red'
        WHEN a.Mathletics_Product_Usage__c = 0 THEN 'black'
        ELSE NULL
    END AS Mathletics_Product_Usage_Status__c,
    a.Mathseeds_Product_Usage__c,
    CASE
        WHEN a.Mathseeds_Product_Usage__c > 75 THEN 'green'
        WHEN a.Mathseeds_Product_Usage__c > 25 THEN 'yellow'
        WHEN a.Mathseeds_Product_Usage__c > 0 THEN 'red'
        WHEN a.Mathseeds_Product_Usage__c = 0 THEN 'black'
        ELSE NULL
    END AS Mathseeds_Product_Usage_Status__c,
    a.Reading_Eggs_Product_Usage__c,
    CASE
        WHEN a.Reading_Eggs_Product_Usage__c > 75 THEN 'green'
        WHEN a.Reading_Eggs_Product_Usage__c > 25 THEN 'yellow'
        WHEN a.Reading_Eggs_Product_Usage__c > 0 THEN 'red'
        WHEN a.Reading_Eggs_Product_Usage__c = 0 THEN 'black'
        ELSE NULL
    END AS Reading_Eggs_Product_Usage_Status__c,
    a.Writing_Legends_Product_Usage__c,
    CASE
        WHEN a.Writing_Legends_Product_Usage__c > 75 THEN 'green'
        WHEN a.Writing_Legends_Product_Usage__c > 25 THEN 'yellow'
        WHEN a.Writing_Legends_Product_Usage__c > 0 THEN 'red'
        WHEN a.Writing_Legends_Product_Usage__c = 0 THEN 'black'
        ELSE NULL
    END AS Writing_Legends_Product_Usage_Status__c FROM (
    SELECT
        cws1.*,
        ROW_NUMBER() OVER(PARTITION BY cws1.ContactEmail ORDER BY cws1.SubscriptionStartDate DESC) AS rn
    FROM
        ContactsWithSubscriptions_V1 cws1
    WHERE
    cws1.SubscriptionProduct IS NOT NULL AND
    cws1.SubscriptionRecordType IN ('Full','Extension') AND
    cws1.SubscriptionStatus = 'Active' AND
    cws1.HasOptedOutOfEmail = 0 AND
    (cws1.ContactTerritory = 'Americas' OR cws1.ContactTerritory = 'Canada' ) AND
    (cws1.SubscriptionTerritory = 'Americas' OR cws1.SubscriptionTerritory = 'Canada') AND
    cws1.SubscriptionStartDate < GETDATE() AND
    cws1.SubscriptionEndDate > GETDATE()
) AS cws
INNER JOIN
    ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id
INNER JOIN ENT.Account_Salesforce a
    ON cws.AccountId = a.Id
WHERE      
(c.Is_Active__c    = 'true' OR
c.Status__c       != 'Inactive' OR
c.HasOptedOutOfEmail = 0) AND
c.Email is not null AND
rn = 1


