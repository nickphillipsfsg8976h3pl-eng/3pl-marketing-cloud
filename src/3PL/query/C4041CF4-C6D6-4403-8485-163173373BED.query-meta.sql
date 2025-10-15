SELECT
    d.LeadKey,
    d.FirstName,
    d.LastName,
    d.FullName,
    d.Email,
    d.MobilePhone,
    d.Locale,
    d.Status,
    d.Stage,
    d.LeadSource,
    d.LeadRating,
    d.EnquiryType,
    d.ReasonLost,
    d.CreatedDate,
    d.LastModifiedDate,
    d.HasOptedOutOfEmail,
    d.MarketingInterest,
    d.MarketingProductInterest,
    d.ProductInterest,
    d.JobTitle,
    d.LeadJobFunction,
    d.ContactRole,
    d.IsExistingCustomer,
    d.Company,
    d.City,
    d.State,
    d.StateCode,
    d.Country,
    d.PostalCode,
    d.CountryCode,
    d.Territory,
    d.LocalAuthority,
    d.Clever,
    d.OwnerEmail,
    d.OwnerFirstName,
    d.OwnerLastName,
    d.CampaignName,
    d.CampaignCode,
    d.LeadCurrencyIsoCode,
    d.EmailBouncedDate
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
            PARTITION BY LTRIM(RTRIM(LOWER(lead.Email)))
            ORDER BY
                COALESCE(lead.LastModifiedDate, lead.CreatedDate) DESC,
                lead.CreatedDate DESC,
                lead.Id DESC
        ) AS rn
    FROM
        ENT.Lead_Salesforce AS lead
        LEFT JOIN ENT.User_Salesforce AS own ON lead.OwnerId = own.Id
    WHERE
        lead.Status = 'Marketing Prospect' AND
        lead.OwnerId != '00G2y000000YaqF' AND          /* Parent Lead Queue ID */
        lead.Product_Interest__c LIKE '%Mathletics%' AND
        lead.IsConverted = 0 AND
        lead.HasOptedOutOfEmail = 0 AND
        lead.Email IS NOT NULL AND
        lead.CountryCode IN ('US','CA') AND
        (
          (lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%')
          OR (lead.Title = '' OR lead.Title IS NULL)
        ) AND
        lead.CreatedDate >= '2022-01-01'
) AS d
WHERE d.rn = 1
