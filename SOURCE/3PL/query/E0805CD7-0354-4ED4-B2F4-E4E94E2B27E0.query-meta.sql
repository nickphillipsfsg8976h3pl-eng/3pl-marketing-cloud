SELECT
    ContactKey,
    SubscriptionProduct,
    SubscriptionRecordType,
    SubscriptionEndDate,
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
    [3P Roster],
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
    SubscriptionType,
    ExistingAccount,
    ActiveFullSubscriptions,
    ocr_Id,
    ocr_Product,
    ocr_ContactId,
    ocr_OpportunityId,
    ocr_Role
FROM (
    SELECT
        cws.ContactKey,
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
        a.OneRosterActivated__c AS [3P Roster],
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
        ocr.Id AS ocr_Id,
        ocr.Product__c AS ocr_Product,
        ocr.ContactId AS ocr_ContactId,
        ocr.OpportunityId AS ocr_OpportunityId,
        ocr.Role AS ocr_Role,
        ROW_NUMBER() OVER (PARTITION BY cws.ContactKey ORDER BY ocr.CreatedDate DESC) AS rn2
    FROM (
        SELECT
            cws1.*,
            ROW_NUMBER() OVER(PARTITION BY cws1.ContactEmail ORDER BY cws1.SubscriptionStartDate DESC) AS rn
        FROM
            ContactsWithSubscriptions_V1 cws1
        WHERE
            cws1.SubscriptionProduct LIKE '%3 Essentials%'
            AND cws1.SubscriptionRecordType = 'Trial'
            AND cws1.SubscriptionStatus = 'Active'
            AND cws1.HasOptedOutOfEmail = 0
            AND cws1.ContactTerritory = 'EME'
            AND cws1.SubscriptionTerritory = 'EME'
            AND cws1.SubscriptionStartDate >= DATEADD(month, -1, GETDATE())
            AND cws1.SubscriptionEndDate > GETDATE()
    ) AS cws
    INNER JOIN ENT.Contact_Salesforce c
        ON cws.ContactKey = c.Id
    INNER JOIN ENT.Account_Salesforce a
        ON cws.AccountId = a.Id
    INNER JOIN ENT.User_Salesforce u
        ON cws.AccountOwnerId = u.Id
    INNER JOIN ENT.OpportunityContactRole_Salesforce ocr
        ON ocr.ContactId = c.Id
    WHERE
        (c.Is_Active__c = 'true'
         OR c.Status__c != 'Inactive'
         OR c.HasOptedOutOfEmail = 0)
        AND c.Email IS NOT NULL
        AND ocr.Role IN ('Teacher Trialist','Subco Trialist')
        AND ocr.Product__c LIKE '%3 Essentials Package%'
        AND rn = 1
) dedup
WHERE rn2 = 1

