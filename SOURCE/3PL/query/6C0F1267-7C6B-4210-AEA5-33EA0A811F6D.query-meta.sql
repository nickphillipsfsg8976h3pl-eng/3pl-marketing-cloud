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
    c.Students_in_WL_Class__c,
    c.first_wl_class_added_date__c
FROM ContactsWithSubscriptions_V1 cws
INNER JOIN ENT.Contact_Salesforce c
        ON  cws.ContactKey = c.Id 
INNER JOIN  ENT.Account_Salesforce a
        ON  cws.AccountID = a.Id
WHERE
    cws.SubscriptionProduct LIKE '%Mathseeds%'  AND
    cws.SubscriptionRecordType IN ('Full','Extension') AND
    cws.SubscriptionStatus = 'Active' AND
    cws.HasOptedOutOfEmail = 0 AND
    cws.SubscriptionStartDate <= GETDATE() AND
    cws.SubscriptionEndDate >= GETDATE() AND
    c.Is_Active__c = 'true' AND
    cws.ContactEmail IS NOT NULL AND
    a.BillingCountryCode ='ZA' AND
    a.BillingCountry ='South Africa' AND
    c.RecordTypeID !='0120I000000pp8lQAA' AND
    a.RecordTypeID !='0120I0000019ZejQAE'