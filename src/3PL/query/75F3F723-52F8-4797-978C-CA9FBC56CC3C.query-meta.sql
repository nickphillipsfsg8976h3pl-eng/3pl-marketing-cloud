SELECT
	lead.Id as LeadKey,
    LEFT(lead.FirstName,40) AS FirstName,
    LEFT(lead.LastName,80) AS LastName,
    lead.Name as FullName,
    LEFT(lead.Email,254) AS Email,
    LEFT(lead.MobilePhone,50) AS MobilePhone,
    lead.Locale__c as Locale,
    lead.Status,
    lead.Lead_Stage__c as Stage,
    lead.LeadSource,
    lead.Lead_Rating__c as LeadRating,
    lead.Enquiry_Type__c as EnquiryType,
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
    lead.Country,
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
    lead.EmailBouncedDate,
    school.Id as SchoolId,
    school.Name__c as SchoolName,
    school.C3_id__c as School_C3_ID,
    school.Country_Code__c as SchoolCountryCode,
    school.State_Code__c as SchoolStateCode,
    school.CurrencyIsoCode as SchoolCurrencyIsoCode
FROM
    ENT.Lead_Salesforce lead LEFT JOIN  
    ENT.User_Salesforce own  ON lead.OwnerId = own.Id LEFT JOIN
    ENT.School__c_Salesforce school ON lead.School__c = school.Id
WHERE
	((lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%') or (lead.Title ='' or lead.Title is null)) AND 
	lead.OwnerId != '00G2y000000YaqF' AND
	lead.IsConverted = 0 AND
	lead.HasOptedOutOfEmail = 0 AND
	lead.Email is NOT NULL