SELECT
	lead.Id as LeadKey,
    LEFT(lead.FirstName,40) AS ContactFirstName,
    LEFT(lead.LastName,80) AS ContactLastName,
    lead.Name as FullName,
    LEFT(lead.Email,254) AS Email,
    LEFT(lead.MobilePhone,50) AS MobilePhone,
    lead.Locale__c as Locale,
    lead.Status,
    lead.Lead_Stage__c as Stage,
    lead.LeadSource,
    lead.Lead_Rating__c as LeadRating,
    lead.Enquiry_Type__c as EnquiryType,
    lead.Reason_Lost__c as ReasonLost,
    lead.CreatedDate AS CreatedDate,
    lead.LastModifiedDate AS LastModifiedDate,
    lead.HasOptedOutOfEmail,
    lead.Marketing_Interest__c as MarketingInterest,
    lead.Marketing_Product_Interest__c as MarketingProductInterest,
    lead.Product_Interest__c as ProductInterest,
    LEFT(lead.Title,126) AS JobTitle,
    LEFT(lead.Job_Function__c,266) AS LeadJobFunction,
    lead.Contact_Role__c as ContactRole,
    lead.Existing_Customer__c as IsExistingCustomer,
    lead.Company,
    lead.City,
    lead.State,
    lead.StateCode,
    lead.Country AS AccountBillingCountry,
    lead.PostalCode,
    lead.CountryCode,
    lead.Territory__c as Territory,
    lead.Local_Authority__c AS LocalAuthority,
    lead.Clever__c as Clever,
    LEFT(own.Email,128) AS OwnerEmail,
    LEFT(own.FirstName,40) AS OwnerFirstName,
    LEFT(own.LastName,80) AS OwnerLastName,
    lead.Campaign_Name__c AS CampaignName,
    lead.Campaign_Code__c AS CampaignCode,
    lead.CurrencyIsoCode AS LeadCurrencyIsoCode,
    lead.EmailBouncedDate
FROM
    ENT.Lead_Salesforce lead LEFT JOIN  
    ENT.User_Salesforce own  ON lead.OwnerId = own.Id 
WHERE
	lead.Status IN ('Closed - Lost','Uncontactable – Nurture','Unqualified') AND	
	lead.OwnerId != '00G2y000000YaqF' AND                     /*Parent Lead Queue ID*/
	lead.Product_Interest__c LIKE '%Reading%' AND
(lead.Reason_Lost__c NOT IN ( 'Fake','Duplicate','Parent Enquiry','Already Subscribed','Already subscribed but unaware','Home/Parent User','Combination - MX & MS' )
	 or (lead.Reason_Lost__c ='' or lead.Reason_Lost__c is null)) AND
	lead.IsConverted = 0 AND
	lead.HasOptedOutOfEmail = 0 AND
	lead.Email is NOT NULL AND
	lead.CountryCode IN ('AU','NZ','ZA') AND
	lead.CreatedDate <= DATEADD(month, -3, GETDATE()) AND
	lead.CreatedDate > DATEADD(year, -3, GETDATE()) AND
	((lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%') or (lead.Title ='' or lead.Title is null))
	AND NOT EXISTS (Select c.Email from Contacts_With_Open_Opportunities c Where c.Email=lead.Email )

UNION

SELECT
	lead.Id as LeadKey,
    LEFT(lead.FirstName,40) AS ContactFirstName,
    LEFT(lead.LastName,80) AS ContactLastName,
    lead.Name as FullName,
    LEFT(lead.Email,254) AS Email,
    LEFT(lead.MobilePhone,50) AS MobilePhone,
    lead.Locale__c as Locale,
    lead.Status,
    lead.Lead_Stage__c as Stage,
    lead.LeadSource,
    lead.Lead_Rating__c as LeadRating,
    lead.Enquiry_Type__c as EnquiryType,
    lead.Reason_Lost__c as ReasonLost,
    lead.CreatedDate AS CreatedDate,
    lead.LastModifiedDate AS LastModifiedDate,
    lead.HasOptedOutOfEmail,
    lead.Marketing_Interest__c as MarketingInterest,
    lead.Marketing_Product_Interest__c as MarketingProductInterest,
    lead.Product_Interest__c as ProductInterest,
    LEFT(lead.Title,126) AS JobTitle,
    LEFT(lead.Job_Function__c,266) AS LeadJobFunction,
    lead.Contact_Role__c as ContactRole,
    lead.Existing_Customer__c as IsExistingCustomer,
    lead.Company,
    lead.City,
    lead.State,
    lead.StateCode,
    lead.Country AS AccountBillingCountry,
    lead.PostalCode,
    lead.CountryCode,
    lead.Territory__c as Territory,
    lead.Local_Authority__c AS LocalAuthority,
    lead.Clever__c as Clever,
    LEFT(own.Email,128) AS OwnerEmail,
    LEFT(own.FirstName,40) AS OwnerFirstName,
    LEFT(own.LastName,80) AS OwnerLastName,
    lead.Campaign_Name__c AS CampaignName,
    lead.Campaign_Code__c AS CampaignCode,
    lead.CurrencyIsoCode AS LeadCurrencyIsoCode,
    lead.EmailBouncedDate
FROM
    ENT.Lead_Salesforce lead LEFT JOIN  
    ENT.User_Salesforce own  ON lead.OwnerId = own.Id 
WHERE
    lead.Status = 'Marketing Prospect' AND	
	lead.OwnerId != '00G2y000000YaqF' AND                     /*Parent Lead Queue ID*/
	lead.Product_Interest__c LIKE '%Reading%' AND
	lead.IsConverted = 0 AND
	lead.HasOptedOutOfEmail = 0 AND
	lead.Email is NOT NULL AND
	((lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%') or (lead.Title ='' or lead.Title is null)) AND
	lead.CountryCode IN ('AU','NZ','ZA') AND
	lead.CreatedDate <= DATEADD(month, -3, GETDATE()) AND
	lead.CreatedDate > DATEADD(year, -3, GETDATE()) AND
	NOT EXISTS
      (SELECT LeadKey
       FROM [Lost leads_MX_marketing prospects_MX product interest only_APAC] mx WHERE mx.LeadKey = Lead.Id )
       