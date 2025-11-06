SELECT
    c.Id as [Contact ID 18],
    c.Email,
    c.FirstName as [First Name],
    c.LastName as [Last Name],
    c.Title as [Job Title],
    cws.ProdName__c as [SubscriptionProduct],
    cws.Start_Date__c as [SubscriptionStartDate],
    cws.End_Date__c as [SubscriptionEndDate],
    a.Id as [Account ID 18],
    a.C3_Id__c as [C3 Id],
    a.Name as [Account Name],
    a.BillingCountry as [Site Country],
    a.Territory__c as Territory,
    a.Status__c as [Account Status],
    rel.roles as [Contact Roles],
    u.Name as [Account Owner],
    u.email as [Account Owner Email]
FROM 
    ENT.Current_Subscription_Details__c_Salesforce cws
INNER JOIN 
    ENT.Account_Salesforce a ON cws.Account__c = a.Id
INNER JOIN 
    ENT.Contact_Salesforce c ON c.AccountId = a.Id
INNER JOIN 
    ENT.AccountContactRelation_Salesforce rel ON c.Id = rel.ContactId AND a.Id = rel.AccountId
INNER JOIN 
    ENT.School_Rollover_Summary__c_Salesforce rs ON rs.Account__c = a.Id
INNER JOIN 
    ENT.School_Rollover__c_Salesforce ro ON rs.School_Rollover__c = ro.Id
LEFT JOIN
    ENT.User_Salesforce u ON u.Id = a.OwnerId

WHERE
    cws.ProdName__c = 'Mathletics' AND
    cws.Status__c LIKE '%Provisioned%' AND
    ro.Rollover_Date__c > '2024-06-15' AND
    ro.Product__c   = 'Mathletics' AND
    c.HasOptedOutOfEmail = 0 AND
    c.Is_Active__c = 'true' AND
    c.Status__c = 'Current' AND
    c.Email IS NOT NULL AND
    rel.Product_Influencer__c LIKE '%Mathletics%' AND
    (rel.roles LIKE '%Subscription Coordinator%' or rel.roles LIKE '%Rollover Contact%') AND
    (a.Name NOT LIKE '%Test%' AND a.Name NOT LIKE '%fake%' AND a.Name NOT LIKE '%inactive%' AND a.Name NOT LIKE '%duplicate%') AND
    a.Territory__c IN ('EME','Canada','Americas') AND
    a.Status__c IN ('Existing Customer','Lapsed Customer','New Customer','Returned Customer')

GROUP BY
    c.Id,
    cws.ProdName__c,
    cws.Start_Date__c,
    cws.End_Date__c,
    a.Name,
    a.BillingCountry,
    a.Territory__c,
    a.Id,
    a.C3_Id__c,
    a.Status__c,
    rel.roles,
    c.Email,
    c.FirstName,
    c.LastName,
    c.Title,
    u.Name,
    u.email
