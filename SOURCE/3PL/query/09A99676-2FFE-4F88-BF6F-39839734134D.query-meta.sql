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
    lead.EmailBouncedDate
FROM
    ENT.Lead_Salesforce lead LEFT JOIN  
    ENT.User_Salesforce own  ON lead.OwnerId = own.Id 
WHERE
	lead.Status IN ('Closed - Lost','Uncontactable – Nurture') AND	
	lead.OwnerId != '00G2y000000YaqF' AND                     /*Parent Lead Queue ID*/
	lead.Product_Interest__c LIKE '%Mathseeds%' AND
    (lead.Reason_Lost__c NOT IN ( 'Fake',
                                  'Duplicate',
                                  'Already subscribed but unaware',
                                  'Parent Enquiry (B2C)',
                                  'Already Subscribed',
                                  'Trial Other 3P Product',
                                  'Sanctioned country')
	 or (lead.Reason_Lost__c ='' or lead.Reason_Lost__c is null)) AND
	lead.IsConverted = 0 AND
	lead.HasOptedOutOfEmail = 0 AND
	lead.Email is NOT NULL AND
	lead.CountryCode IN ('US', 'AI', 'AG', 'AR', 'AW', 'BS', 'BB', 'BZ', 'BM', 'BO', 'BQ', 'BR', 'CA', 'KY', 'CL', 'CO', 'CR', 'CU', 'CW', 'DM', 'DO', 'EC', 'SV', 'FK', 'GF', 'GL', 'GD', 'GP', 'GT', 'GY', 'HT', 'HN', 'JM', 'MQ', 'MX', 'MS', 'AN', 'NI', 'PA', 'PY', 'PE', 'BL', 'KN', 'LC', 'MF', 'PM', 'VC', 'SX', 'SR', 'TT', 'TC', 'UY', 'VE', 'VG')
 AND
	((lead.Title NOT LIKE '%Parent%' AND lead.Title NOT LIKE '%Student%') or (lead.Title ='' or lead.Title is null))
	AND NOT EXISTS (Select c.Email from Contacts_With_Open_Opportunities c Where c.Email=lead.Email )