SELECT
    DISTINCT a.Id as SubscriberKey,
    a.Id as AccountId,
    a.C3_Id__c as C3ID,
    a.School_Type__c as [School Type],
    a.School_Category__c as [School Category],
    a.Name as [Account Name],
    a.Email__c as [School Email],
    a.Email_Opt_Out__c as [AccountEmailOptOut],
    a.BillingCountry as [Site Country],
    a.BillingCountryCode as [BillingCountryCode],
    a.BillingState as [Site State Province],
    a.Territory__c as [Territory__c],
    u.Name as [Account owner full name],
    a.Email__c as ContactEmail,
    'School Email' as ContactType,
    u.UserName as UserName,
    u.ESC_Contact_Number__c as [ESC contact number],
    u.Email as [ESC email address],
    u.ESC_chili_calendar_link__c as [ESC chili calendar link]


FROM [Renewal Opportunity - LookUp Table_Excluding3E_Email4] r
INNER JOIN  ENT.Account_Salesforce a
        ON  r.AccountID = a.Id
LEFT JOIN  ENT.User_Salesforce u
        ON  u.Id = a.OwnerId 
WHERE

    a.Email__c         IS NOT NULL AND
    a.Email_Opt_Out__c = 0 AND
    a.Territory__c ='APAC' AND
    a.BillingCountryCode IN ('AU') AND
    (a.Name                     NOT LIKE '%fake%' OR
    a.Name                     NOT LIKE '%inactive%' OR
    a.Name                     NOT LIKE '%duplicate%') AND
    a.RecordTypeID             !='0120I0000019ZejQAE'                      

