SELECT
    LeadKey,
    FirstName,
    LastName,
    FullName,
    Email,
    MobilePhone,
    Locale,
    Status,
    Stage,
    LeadSource,
    LeadRating,
    EnquiryType,
    ReasonLost,
    CreatedDate,
    LastModifiedDate,
    HasOptedOutOfEmail,
    MarketingInterest,
    MarketingProductInterest,
    ProductInterest,
    JobTitle,
    LeadJobFunction,
    ContactRole,
    IsExistingCustomer,
    Company,
    City,
    State,
    StateCode,
    Country,
    PostalCode,
    CountryCode,
    Territory,
    LocalAuthority,
    Clever,
    OwnerEmail,
    OwnerFirstName,
    OwnerLastName,
    CampaignName,
    CampaignCode,
    LeadCurrencyIsoCode,
    EmailBouncedDate
FROM (
    SELECT
        lead.Id AS LeadKey,
        LEFT(lead.FirstName,40) AS FirstName,
        LEFT(lead.LastName,80) AS LastName,
        lead.Name AS FullName,
        LEFT(lead.Email,254) AS Email,
        LEFT(lead.MobilePhone,50) AS MobilePhone,
        lead.Locale__c AS Locale,
        lead.Status,
        lead.Lead_Stage__c AS Stage,
        lead.LeadSource,
        lead.Lead_Rating__c AS LeadRating,
        lead.Enquiry_Type__c AS EnquiryType,
        lead.Reason_Lost__c AS ReasonLost,
        lead.CreatedDate AS CreatedDate,
        lead.LastModifiedDate AS LastModifiedDate,
        lead.HasOptedOutOfEmail,
        lead.Marketing_Interest__c AS MarketingInterest,
        lead.Marketing_Product_Interest__c AS MarketingProductInterest,
        lead.Product_Interest__c AS ProductInterest,
        LEFT(lead.Title,126) AS JobTitle,
        LEFT(lead.Job_Function__c,266) AS LeadJobFunction,
        lead.Contact_Role__c AS ContactRole,
        lead.Existing_Customer__c AS IsExistingCustomer,
        lead.Company,
        lead.City,
        lead.State,
        lead.StateCode,
        lead.Country,
        lead.PostalCode,
        lead.CountryCode,
        lead.Territory__c AS Territory,
        lead.Local_Authority__c AS LocalAuthority,
        lead.Clever__c AS Clever,
        LEFT(own.Email,128) AS OwnerEmail,
        LEFT(own.FirstName,40) AS OwnerFirstName,
        LEFT(own.LastName,80) AS OwnerLastName,
        lead.Campaign_Name__c AS CampaignName,
        lead.Campaign_Code__c AS CampaignCode,
        lead.CurrencyIsoCode AS LeadCurrencyIsoCode,
        lead.EmailBouncedDate,
        ROW_NUMBER() OVER (
            PARTITION BY lead.Email
            ORDER BY lead.CreatedDate DESC
        ) AS rn
    FROM
        ENT.Lead_Salesforce lead
    LEFT JOIN ENT.User_Salesforce own  
        ON lead.OwnerId = own.Id 
    WHERE
        lead.Status = 'Marketing Prospect'
        AND lead.OwnerId != '00G2y000000YaqF'    /*Parent Lead Queue ID*/
        AND lead.Product_Interest__c LIKE '%ReadingEggs%'
        AND lead.IsConverted = 0
        AND lead.HasOptedOutOfEmail = 0
        AND lead.Email IS NOT NULL
        AND lead.CountryCode IN ('AU','NZ','SA')
        AND (
            (lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%')
            OR (lead.Title = '' OR lead.Title IS NULL)
        )
        AND lead.CreatedDate >= '2022-01-01'
) t
WHERE rn = 1
