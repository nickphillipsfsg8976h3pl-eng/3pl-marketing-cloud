SELECT 
c.chargebeeapps__CustomerID__c as ContactID,
c.Id, 
c.Name,
co.Email,
co.FirstName,
co.HasOptedOutOfEmail,
co.Job_Function__c,
co.LastActivityDate,
co.LastModifiedById,
co.LastModifiedDate,
co.LeadSource,
co.Marketing_Interest__c,
co.Marketing_Product_Interest__c,
co.MobilePhone,
co.LastName,
co.Phone,
co.School_C3_Id__c,
co.School_Category__c,
co.School_Territory__c,
co.Status__c,
co.Tech_GUID__c,
co.UTM_Campaign__c,
co.UTM_Content__c,
co.UTM_Medium__c,
co.UTM_Source__c,
co.UTM_Term__c,
c.chargebeeapps__Subscription_status__c, 
c.chargebeeapps__Subcription_Activated_At__c, 
c.chargebeeapps__Subscription_Created_At__c,
c.chargebeeapps__Next_billing__c, 
c.chargebeeapps__Subcription_Cancelled_At__c,              
c.chargebeeapps__Subscription_Plan__c,
u.Country,
u.CountryCode,
u.State,
u.StateCode,
u.LanguageLocaleKey,
u.LastLoginDate as LastLogin_ParentDashboard
FROM Ent.chargebeeapps__CB_Subscription__c_Salesforce c
JOIN Ent.Contact_Salesforce AS co
        ON c.chargebeeapps__CustomerID__c = co.ContactID_18__c
JOIN Ent.User_Salesforce AS u
        ON co.ContactID_18__c = u.ContactId 
where 
(chargebeeapps__Subscription_status__c ='ACTIVE'
Or chargebeeapps__Subscription_status__c  = 'NON_RENEWING')
AND chargebeeapps__Current_Term_End__c > GETDATE()