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
    a.OneRosterActivated__c AS [3p roster],
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
    u.Email AS username,
    COALESCE(u.MobilePhone, u.Phone) AS phone,
    u.FirstName AS ownerfirstname,
    u.LastName AS ownerlastname,
    u.Name AS accountowner,
    cws.SubscriptionStartDate,
    cws.SubscriptionCapacity,
    cws.SubscriptionExpired,
    cws.SubscriptionStatus,
    cws.SubscriptionTerritory,
    cws.SubscriptionQuantity,
    cws.SubscriptionType,
    cws.ExistingAccount,
    cws.ActiveFullSubscriptions

FROM (
    SELECT
        cws1.*,
        ROW_NUMBER() OVER (
            PARTITION BY cws1.ContactEmail 
            ORDER BY cws1.SubscriptionStartDate DESC
        ) AS rn
    FROM ContactsWithSubscriptions_V1 cws1
    WHERE
        cws1.SubscriptionStatus = 'Active' AND
        cws1.HasOptedOutOfEmail = 0 AND
        cws1.AccountBillingCountryCode IN ('GB','IE') AND
        cws1.SubscriptionStartDate < CAST(GETDATE() AS DATE) AND
        cws1.SubscriptionEndDate > GETDATE()
) AS cws

INNER JOIN ENT.Contact_Salesforce c
    ON cws.ContactKey = c.Id

INNER JOIN ENT.Account_Salesforce a
    ON cws.AccountId = a.Id

INNER JOIN ENT.User_Salesforce u
    ON cws.AccountOwnerId = u.Id

WHERE
    (
        c.Is_Active__c = 'true' OR
        c.Status__c != 'Inactive' OR
        c.HasOptedOutOfEmail = 0
    ) AND
    c.Email IS NOT NULL AND
    a.LastModifiedDate >= CAST(DATEADD(day, -1, GETDATE()) AS DATE) AND
    a.OneRosterActivated__c = 1 AND
    (cws.ContactRoles IS NULL OR
        (
            cws.ContactRoles NOT LIKE '%finance%' AND
            cws.ContactRoles NOT LIKE '%signatory%' AND
            cws.ContactRoles NOT LIKE '%accounts%' AND
            cws.ContactRoles NOT LIKE '%accounts payable%'
        )
    ) AND
    rn = 1
