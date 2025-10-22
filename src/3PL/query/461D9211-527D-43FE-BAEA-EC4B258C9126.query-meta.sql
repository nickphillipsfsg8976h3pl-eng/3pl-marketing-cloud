SELECT 
    co.ContactID_18__c as ContactID,
    co.Id, 
    co.Email,
    co.FirstName,
    co.HasOptedOutOfEmail,
    co.LastModifiedById,
    co.LastModifiedDate,
    co.LeadSource,
    co.Marketing_Interest__c,
    co.Marketing_Product_Interest__c,
    co.MobilePhone,
    co.LastName,
    co.Phone,
    co.Status__c,
    co.UTM_Campaign__c,
    co.UTM_Content__c,
    co.UTM_Medium__c,
    co.UTM_Source__c,
    co.UTM_Term__c,
    c.chargebeeapps__Subscription_status__c, 
    u.Country,
    u.CountryCode,
    u.State,
    u.StateCode,
    u.LanguageLocaleKey,
    u.LastLoginDate as LastLogin_ParentDashboard,
    co.CreatedDate,
    co.CurrencyIsoCode,
    co.RecordTypeId
FROM Ent.Contact_Salesforce AS co
LEFT JOIN Ent.chargebeeapps__CB_Subscription__c_Salesforce c
    ON c.chargebeeapps__CustomerID__c = co.ContactID_18__c
LEFT JOIN Ent.User_Salesforce AS u
    ON co.ContactID_18__c = u.ContactId        
WHERE 
    c.chargebeeapps__CustomerID__c IS NULL
    AND co.RecordTypeId = '0120I000000pp8lQAA'