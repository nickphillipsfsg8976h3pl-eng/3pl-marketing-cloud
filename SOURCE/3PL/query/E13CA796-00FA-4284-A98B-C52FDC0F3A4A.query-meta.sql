SELECT
    c._ContactKey AS ContactKey,
    LEFT(sub.SBQQ__ProductName__c,80) AS SubscriptionProduct,
    LEFT(sub.Type__c,80) AS SubscriptionRecordType,
    sub.SBQQ__SubscriptionEndDate__c AS SubscriptionEndDate,   
    sub.Id AS SubscriptionId,

    LEFT(c.Title,126) AS ContactTitle,
    LEFT(c.FirstName,40) AS ContactFirstName,
    LEFT(c.LastName,80) AS ContactLastName,
    LEFT(c.Email,254) AS ContactEmail,
    LEFT(c.MobilePhone,50) AS ContactMobilePhone,
    LEFT(ac.BillingCountryCode,5) AS ContactLocale,
    c.HasOptedOutOfEmail,
    c.CreatedDate AS ContactCreateDate,
    c.LastModifiedDate AS LastModifiedDate,
    LEFT(c.Job_Function__c,266) AS ContactJobFunction,
    LEFT(c.Status__c,50) AS ContactStatus,
    rel.Roles AS ContactRoles,
    LEFT(c.Territory__c,50) AS ContactTerritory,
    LEFT(c.Salutation,50) AS ContactSalutation,
    LEFT(c.Product_Influencer__c,150) AS ContactProductInfluencer,
    LEFT(c.Marketing_Interest__c,250) AS ContactMarketingInterest,
    LEFT(c.Marketing_Product_Interest__c,250) AS ContactMarketingProductInterest,
    c.RecordTypeId AS ContactRecordTypeID,

    
    ac.Id AS AccountId,
    LEFT(ac.Name,255) AS AccountName,

    LEFT(ac.Global_School_Category__c,50) AS AccountGlobalSchoolCategory,
    LEFT(ac.Local_Authority__c,255) AS AccountLocalAuthority,

    ac.OwnerId AS AccountOwnerId,
    LEFT(ac.BillingStreet,255) AS AccountBillingStreet,
    LEFT(ac.BillingCity,40) AS AccountBillingCity,
    LEFT(ac.BillingState,80) AS AccountBillingState,
    LEFT(ac.BillingStateCode,10) AS AccountBillingStateCode,
    LEFT(ac.BillingPostalCode,20) AS AccountBillingPostalCode,
    LEFT(ac.BillingCountry,80) AS AccountBillingCountry,
    LEFT(ac.BillingCountryCode,10) AS AccountBillingCountryCode,
    LEFT(ac.Status__c,255) as AccountStatus,

    ct.Id as ContractId,
    ct.StartDate AS ContractStartDate,
    ct.EndDate AS ContractEndDate,
    ct.Expiration_Date_Multi_Year_Deal__c AS ContractMultiYearExpiration,
    ct.ContractNumber AS ContractNumber,    
    ct.SBQQ__Opportunity__c AS OpportunityId,
    ct.SBQQ__Quote__c AS QuoteId,
    ct.SBQQ__RenewalOpportunity__c AS RenewalOpportunityId,

    LEFT(op.[Type],80) AS OpportunityType,
    LEFT(op.StageName,80) AS OpportunityStage,
    op.OwnerId AS OpportunityOwnerId,
    LEFT(op.Owner_Role__c,80) AS OpportunityOwnerRole,
    LEFT(op.Converted__c,10) AS OpportunityConverted,
    LEFT(op.Won_Lost_Reason__c,100) AS OpportunityWonLostReason,
    LEFT(op.Opp_Stage_Before_Lost__c,100) AS OpportunityOppStageBeforeLost,
    op.IsClosed AS OpportunityIsClosed,
    op.IsWon AS OpportunityIsWon,


    LEFT(own.Email,128) AS OwnerEmail,
    LEFT(own.FirstName,40) AS OwnerFirstName,
    LEFT(own.LastName,80) AS OwnerLastName,

    ROW_NUMBER() OVER(PARTITION BY c.Id, sub.SBQQ__ProductName__c, sub.[Type__c], sub.SBQQ__SubscriptionEndDate__c ORDER BY sub.SBQQ__SubscriptionStartDate__c ASC) AS RowNumber,


    sub.SBQQ__SubscriptionStartDate__c AS SubscriptionStartDate,
    sub.SBQQ__Quantity__c AS SubscriptionCapacity,
    sub.Is_Expired__c AS SubscriptionExpired,
    LEFT(sub.Status__c,50) AS SubscriptionStatus,
    LEFT(sub.Territory__c,50) AS SubscriptionTerritory,
    sub.SBQQ__Quantity__c AS SubscriptionQuantity,
    LEFT(sub.SBQQ__SubscriptionType__c,255) AS SubscriptionType


FROM
    ENT.SBQQ__Subscription__c_Salesforce sub INNER JOIN
    ENT.Account_Salesforce ac
        ON  sub.SBQQ__ACCOUNT__C = ac.Id LEFT JOIN
    ENT.Contract_Salesforce ct
        ON  sub.SBQQ__Contract__c = ct.Id INNER JOIN
    ENT.AccountContactRelation_Salesforce rel
        ON  ac.Id = rel.AccountId INNER JOIN
    ENT.Contact_Salesforce c
        ON  rel.ContactId = c.Id LEFT JOIN
    ENT.Opportunity_Salesforce op
        ON  ct.SBQQ__Opportunity__c = op.Id LEFT JOIN
    ENT.User_Salesforce own
        ON  op.OwnerId = own.Id
WHERE
    sub.SBQQ__SubscriptionEndDate__c IS NOT NULL AND
    sub.[Type__c] IS NOT NULL AND
    sub.SBQQ__ProductName__c IS NOT NULL AND
    c.Is_Active__c = 'true' AND
    rel.IsActive = 1 AND
    c.Email IS NOT NULL AND
    c.RecordTypeID !='0120I000000pp8lQAA' AND
    ac.RecordTypeID !='0120I0000019ZejQAE'