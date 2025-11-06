SELECT
    c.Id as [Contact ID 18],
    cws.ProdName__c,
    cws.Start_Date__c,
    cws.End_Date__c,
    a.Name as [Account Name],
    a.BillingCountry as [Site Country],
    a.Territory__c as Territory,
    a.Id as [Account ID 18],
    c.Email,
    c.FirstName as [First Name],
    c.LastName as [Last Name],
    MAX(o.CloseDate) as LatestCloseDate,
    a.CSM_Owner__c,
    a.CSM_Owner2__c,
    u.Name as [CSM Owner1 Name] ,
    a.CSM_Managed_Products__c as [CSM Managed Products1],
    u2.Name as [CSM Owner2 Name],
    a.CSM_Managed_Products2__c as [CSM Managed Products2],
    u3.Name as [Account Owner],
    u3.email as [Account Owner Email]

FROM 
    ENT.Current_Subscription_Details__c_Salesforce cws
INNER JOIN 
    ENT.Account_Salesforce a ON cws.Account__c = a.Id
INNER JOIN 
    ENT.Contact_Salesforce c ON c.AccountId = a.Id
INNER JOIN 
    ENT.AccountContactRelation_Salesforce rel ON c.Id = rel.ContactId AND a.Id = rel.AccountId
INNER JOIN 
    ENT.Opportunity_Salesforce o ON o.AccountId = a.Id
LEFT JOIN
    ENT.User_Salesforce u ON u.Id = a.CSM_Owner__c
LEFT JOIN
    ENT.User_Salesforce u2 ON u2.Id = a.CSM_Owner2__c
LEFT JOIN
    ENT.User_Salesforce u3 ON u3.Id = a.OwnerId
WHERE
    cws.ProdName__c LIKE '%WritingLegends%' AND
    cws.Status__c LIKE '%Provisioned%' AND
    cws.Start_Date__c > DATEADD(month, -2, GETDATE()) AND
    cws.End_Date__c > DATEADD(day, 0, GETDATE()) AND
    c.HasOptedOutOfEmail = 0 AND
    c.Is_Active__c = 'true' AND
    c.Status__c = 'Current' AND
    (c.Title = 'teacher' OR c.Title LIKE '%Subscription Coordinator%' OR c.Title LIKE '%admin%') AND 
    rel.Product_Influencer__c LIKE '%WritingLegends%' AND
    c.Email IS NOT NULL AND
    (a.Name NOT LIKE '%Test%' AND a.Name NOT LIKE '%fake%' AND a.Name NOT LIKE '%inactive%' AND a.Name NOT LIKE '%duplicate%') AND
    o.Type = 'New Business' AND
    o.Productlist__c LIKE '%Writing%' AND
    o.StageName = 'Sold - Contracted' AND
    o.CloseDate >= DATEADD(month, -2, GETDATE())
GROUP BY
    c.Id,
    cws.ProdName__c,
    cws.Start_Date__c,
    cws.End_Date__c,
    a.Name,
    a.BillingCountry,
    a.Territory__c,
    a.Id,
    c.Email,
    c.FirstName,
    c.LastName,
    a.CSM_Owner__c,
    a.CSM_Owner2__c,
    u.Name  ,
    a.CSM_Managed_Products__c,
    u2.Name,
    a.CSM_Managed_Products2__c,
    u3.Name,
    u3.email
