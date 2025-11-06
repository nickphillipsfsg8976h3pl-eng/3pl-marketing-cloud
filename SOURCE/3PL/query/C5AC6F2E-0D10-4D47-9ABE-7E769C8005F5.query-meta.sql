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
    a.OneRosterActivated__c as [3P Roster],

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

    u.Email as UserName,
   COALESCE(u.MobilePhone, u.Phone) as Phone,
    u.FirstName as OwnerFirstName,
    u.LastName as OwnerLastName,
    u.Name as AccountOwner,
    
    cws.SubscriptionStartDate,
    cws.SubscriptionCapacity,
    cws.SubscriptionExpired,
    cws.SubscriptionStatus,
    cws.SubscriptionTerritory,
    cws.SubscriptionQuantity,
    cws.SubscriptionType,
    cws.ExistingAccount,
    cws.ActiveFullSubscriptions FROM (
    SELECT
        cws1.*,
        ROW_NUMBER() OVER(PARTITION BY cws1.ContactEmail ORDER BY cws1.SubscriptionStartDate DESC) AS rn
    FROM
        ContactsWithSubscriptions_V1 cws1
    WHERE
    cws1.SubscriptionProduct NOT LIKE '%3 Essentials%' AND
    cws1.ActiveFullSubscriptions NOT LIKE '%3 Essentials%' AND
    cws1.AccountGlobalSchoolCategory = 'Primary' AND
    cws1.SubscriptionStatus = 'Active' AND
    cws1.HasOptedOutOfEmail = 0 AND
    cws1.ContactTerritory = 'APAC' AND
    cws1.SubscriptionTerritory = 'APAC' AND
    cws1.AccountBillingCountryCode = 'AU' AND
    cws1.SubscriptionStartDate < CAST(GETDATE() AS DATE) AND
    cws1.SubscriptionEndDate > GETDATE() AND
    (cws1.ContactRoles IS NULL OR cws1.ContactRoles ='' OR
        (
            cws1.ContactRoles NOT LIKE '%finance%' AND
            cws1.ContactRoles NOT LIKE '%signatory%' AND
            cws1.ContactRoles NOT LIKE '%accounts%' AND
            cws1.ContactRoles NOT LIKE '%accounts payable%'
        )
    ) 
) AS cws
INNER JOIN
    ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id
INNER JOIN
    ENT.Account_Salesforce a
        ON cws.AccountId = a.Id
INNER JOIN
    ENT.User_Salesforce u
        ON cws.AccountOwnerId = u.Id
WHERE      
(c.Is_Active__c    = 'true' OR
c.Status__c       != 'Inactive' OR
c.HasOptedOutOfEmail = 0) AND
c.Email is not null AND

rn = 1

