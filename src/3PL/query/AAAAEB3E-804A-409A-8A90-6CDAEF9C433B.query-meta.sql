SELECT
    DISTINCT cws.ContactKey,
   
    cws.SubscriptionProduct,
    cws.SubscriptionRecordType,
    cws.SubscriptionEndDate,
    cws.SubscriptionId,

    cws.ContactTitle,
    cws.ContactFirstName as FirstName,
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
    cws.AccountName as SchoolName,
    srs.Id as SchooRolloverSummaryId,
    r.Id as SchoolRolloverId,
    r.Product__c as SchoolRolloverProduct,
    r.Rollover_Date__c as SchoolRolloverDate,
    r.Type__c as SchoolRolloverType,
    r.Name as SchoolRolloverName
FROM ContactsWithSubscriptions_V1 cws
INNER JOIN ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id 
INNER JOIN  ENT.Account_Salesforce a
        ON  cws.AccountID = a.Id
INNER JOIN  ENT.AccountContactRelation_Salesforce rel
        ON  cws.ContactKey = rel.ContactId
INNER JOIN ENT.SCHOOL_ROLLOVER_SUMMARY__C_SALESFORCE srs
        ON srs.Account__c = a.Id
INNER JOIN ENT.SCHOOL_ROLLOVER__C_SALESFORCE r
        ON srs.School_Rollover__c = r.Id
WHERE
    cws.SubscriptionRecordType IN ('Full','Extension') AND
    cws.SubscriptionProduct    = 'Mathletics' AND
    cws.HasOptedOutOfEmail     = 0 AND
    cws.SubscriptionEndDate    >=  DATEADD(day, 0, GETDATE()) AND
    c.Is_Active__c             = 'true' AND
    c.Status__c                = 'Current' AND
    cws.ContactEmail           IS NOT NULL AND
    a.Territory__c             = 'EME' AND
    a.IsTestAccount__c         = 0 AND
    (a.Name                    NOT LIKE '%Test%' OR 
    a.Name                     NOT LIKE '%fake%' OR
    a.Name                     NOT LIKE '%inactive%' OR
    a.Name                     NOT LIKE '%duplicate%') AND
    c.RecordTypeID             !='0120I000000pp8lQAA' AND       
    a.RecordTypeID             !='0120I0000019ZejQAE' AND
    r.Rollover_Date__c         >='2023-01-07' AND
    ((r.Product__c            = cws.SubscriptionProduct) OR
     (r.Product__c            = 'ReadingEggs' AND 
      cws.SubscriptionProduct = 'Reading Eggs'))
