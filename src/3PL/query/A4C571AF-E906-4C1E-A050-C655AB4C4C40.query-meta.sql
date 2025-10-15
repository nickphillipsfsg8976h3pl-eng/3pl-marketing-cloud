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
    cws.ActiveFullSubscriptions FROM (
    SELECT
        cws1.*,
        ROW_NUMBER() OVER(PARTITION BY cws1.ContactEmail ORDER BY cws1.SubscriptionStartDate DESC) AS rn
    FROM
        ContactsWithSubscriptions_V1 cws1
    WHERE
    
    cws1.ActiveFullSubscriptions LIKE '%Reading%' AND
    cws1.ActiveFullSubscriptions LIKE '%Mathletics%' AND
    cws1.ActiveFullSubscriptions LIKE '%Mathseeds%' AND
    cws1.SubscriptionRecordType IN ('Full','Extension') AND
    cws1.SubscriptionStatus = 'Active' AND
    cws1.ContactTerritory = 'APAC' AND
    cws1.SubscriptionTerritory = 'APAC' AND
    cws1.HasOptedOutOfEmail = 0 AND
    cws1.SubscriptionStartDate < GETDATE() AND
    cws1.SubscriptionEndDate > GETDATE()
) AS cws
INNER JOIN
    ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id
/* Exclude subscribers who have opened or clicked emails in the last 6 months */
LEFT JOIN 
    _Open o ON cws.ContactKey = o.SubscriberKey
              AND o.EventDate >= DATEADD(month, -6, GETDATE())
LEFT JOIN 
    _Click cl ON cws.ContactKey = cl.SubscriberKey
               AND cl.EventDate >= DATEADD(month, -6, GETDATE())
WHERE      
(c.Is_Active__c    = 'true' OR
c.Status__c       != 'Inactive' OR
c.HasOptedOutOfEmail = 0) AND
c.Email is not null AND
o.SubscriberKey IS NULL AND 
cl.SubscriberKey IS NULL AND
rn = 1

