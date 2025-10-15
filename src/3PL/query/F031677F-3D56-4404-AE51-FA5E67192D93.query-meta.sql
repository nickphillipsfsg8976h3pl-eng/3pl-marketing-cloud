SELECT
    DISTINCT cws.ContactKey,
    cws.SubscriptionProduct,
    cws.SubscriptionRecordType,
    cws.SubscriptionEndDate,
    cws.SubscriptionId,

    cws.ContactTitle,
    cws.ContactFirstName ,
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
    cws.AccountName as SchoolName
FROM ContactsWithSubscriptions_V1 cws
INNER JOIN ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id 
INNER JOIN  ENT.Account_Salesforce a
        ON  cws.AccountID = a.Id
INNER JOIN  ENT.AccountContactRelation_Salesforce rel
        ON  cws.ContactKey = rel.ContactId
WHERE
    cws.SubscriptionProduct    LIKE '%Mathletics%'  AND
    cws.SubscriptionRecordType IN ('Full','Extension') AND
    cws.ContactRoles           LIKE '%Subscription Coordinator%' AND
    cws.HasOptedOutOfEmail     = 0 AND
    cws.SubscriptionEndDate    <= DATEADD(month, -3, GETDATE()) AND
    cws.SubscriptionEndDate    >  DATEADD(year, -3, GETDATE()) AND
    c.Is_Active__c             = 'true' AND
    c.Status__c                = 'Current' AND
    rel.Product_Influencer__c  LIKE '%Mathletics%' AND
    cws.ContactEmail           IS NOT NULL AND
    cws.AccountBillingCountryCode  IN ('AU','NZ','ZA') AND
    (a.Name                    NOT LIKE '%Test%' OR 
    a.Name                     NOT LIKE '%fake%' OR
    a.Name                     NOT LIKE '%inactive%' OR
    a.Name                     NOT LIKE '%duplicate%') AND
    c.RecordTypeID             !='0120I000000pp8lQAA' AND                  /* Exclude Home Parent RecType */
    a.RecordTypeID             !='0120I0000019ZejQAE'                      /* Exclude Home RecType */
   
       AND NOT EXISTS (Select c.Email from Contacts_With_Open_Opportunities c Where  cws.ContactEmail=c.Email )