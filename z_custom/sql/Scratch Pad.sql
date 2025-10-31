SELECT
    sub.Status as SubscriberStatus,
    l.Id as SubscriberKey,
    l.Id as LeadId,
    l.Email as LeadEmail,
    l.Company as LeadSchoolName,
    l.OrganisationEmail__c as LeadOrganisationalEmail,
    l.Name as LeadName,
    l.FirstName as LeadFirstName,
    l.LastName as LeadLastName,
    l.Job_Function__c as LeadJobFunction,
    l.Title as LeadJobTitle,
    l.Grade_Level__c as LeadGradeLevel,
    l.Lead_Stage__c as LeadStage,
    l.Status as LeadStatus,
    l.Product_Interest__c as LeadProductInterest,
    l.LeadSource as LeadSource,
    l.Campaign_Name__c as LeadCampaignName,
    l.UTM_Campaign__c as LeadUTMCampaign,
    l.LastModifiedDate as LeadLastModifiedDate,
    l.MQL_Timestamp__c as LeadMQLTimestamp,
    l.Country as LeadCountry,
    l.HasOptedOutOfEmail as LeadHasOptedOutOfEmail,
    u.Name as OwnerName,
    u.Email as OwnerEmail,
    s.Name__c as SchoolName,
    sa.Id as SchoolAccountId,
    sa.Name as SchoolAccountName,
    sa.Account_Segment__c as SchoolAccountSegment,
    sa.Status__c as SchoolAccountStatus,
    sa.School_Classification__c as SchoolAccountClassification,
    sa.Territory__c as SchoolAccountTerritory,
    sa.School_Type__c as SchoolAccountSchoolType,
    sa.School_Category__c as SchoolAccountSchoolCategory,
    sa.Total_Number_Students__c as SchoolAccountStudents,
    sa.School_Years_Start__c as SchoolAccountYearsStart,
    sa.School_Years_End__c as SchoolAccountYearsEnd,
    sa.External_Provider_Name__c as SchoolAccountExternalProviderName,
    sa.BillingCountry as SchoolAccountBillingCountry,
    sa.BillingState as SchoolAccountBillingStateProvince,
    sa.BillingPostalCode as SchoolAccountBillingPostalZipCode,
    sau.Name as SchoolAccountOwnerName,
    sau.Email as SchoolAccountOwnerEmail
FROM
    AMER_MX_Leads_MarketingProspects_EXCLUDE p
    LEFT JOIN ENT.Lead_Salesforce l ON l.Id = p.Id
    LEFT JOIN ENT.User_Salesforce u ON l.OwnerId = u.Id
    LEFT JOIN ENT.School__c_Salesforce s ON l.School__c = s.Id
    LEFT JOIN ENT.Account_Salesforce sa ON sa.Id = s.Account__c
    LEFT JOIN ENT.User_Salesforce sau ON sau.Id = sa.OwnerId
    LEFT JOIN _Subscribers sub ON l.Id = sub.SubscriberKey