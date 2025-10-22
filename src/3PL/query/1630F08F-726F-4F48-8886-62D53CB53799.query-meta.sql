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
    cws1.SubscriptionProduct IS NOT NULL AND
    cws1.SubscriptionProduct IN 
       ('Brightpath Progress Writing',
        'Brightpath Progress Maths',
    	'Mathletics',
    	'Mathseeds',
    	'Reading Eggs',
    	'Writing Legends') AND
    cws1.SubscriptionRecordType IN ('Full','Extension') AND
    cws1.SubscriptionStatus = 'Active' AND
    cws1.HasOptedOutOfEmail = 0 AND
    cws1.AccountBillingCountry  IN ('Australia','New Zealand') AND
    cws1.SubscriptionStartDate < GETDATE() AND
    cws1.SubscriptionEndDate > GETDATE()
) AS cws
INNER JOIN
    ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id
INNER JOIN  ENT.Account_Salesforce a
        ON  cws.AccountID = a.Id
INNER JOIN  ENT.AccountContactRelation_Salesforce rel
        ON  cws.ContactKey = rel.ContactId
WHERE      
(c.Is_Active__c    = 'true' OR
c.Status__c       != 'Inactive' OR
c.HasOptedOutOfEmail = 0) AND
c.Email is not null AND
a.Territory__c             = 'APAC' AND
(a.Name                    NOT LIKE '%Test%' OR 
 a.Name                     NOT LIKE '%fake%' OR
 a.Name                     NOT LIKE '%inactive%' OR
 a.Name                     NOT LIKE '%duplicate%') AND
 c.RecordTypeID             !='0120I000000pp8lQAA' AND                  
 a.RecordTypeID             !='0120I0000019ZejQAE' AND
rn = 1
