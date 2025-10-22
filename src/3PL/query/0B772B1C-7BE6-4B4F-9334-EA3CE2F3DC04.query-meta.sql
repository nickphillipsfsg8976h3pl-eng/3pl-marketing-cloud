SELECT
    c.Id AS [Contact ID 18],
    cws.ProdName__c as [Product Name],
    cws.Start_Date__c as [StartDate],
    cws.End_Date__c as [EndDate],
    a.Name AS [Account Name],
    a.BillingCountry AS [Site Country],
    a.Territory__c AS Territory,
    a.Id AS [Account ID 18],
    c.Email,
    c.FirstName AS [First Name],
    c.LastName AS [Last Name],
    a.CSM_Owner__c,
    a.CSM_Owner2__c,
    u.Name AS [CSM Owner1 Name],
    a.CSM_Managed_Products__c AS [CSM Managed Products1],
    u2.Name AS [CSM Owner2 Name],
    a.CSM_Managed_Products2__c AS [CSM Managed Products2],
    u3.Name AS [Account Owner],
    u3.Email AS [Account Owner Email],
    c.Title as [Title],
    rel.Roles as [Roles],
    cws.Id as [SubscriptionSummaryId],
    cws.Status__c as [Status],
    cws.License_Type__c as [License Type]
    

FROM 
    ENT.Current_Subscription_Details__c_Salesforce cws
INNER JOIN 
    ENT.Account_Salesforce a ON cws.Account__c = a.Id
INNER JOIN 
    ENT.Contact_Salesforce c ON c.AccountId = a.Id
INNER JOIN 
    ENT.AccountContactRelation_Salesforce rel ON c.Id = rel.ContactId AND a.Id = rel.AccountId
LEFT JOIN 
    ENT.User_Salesforce u ON u.Id = a.CSM_Owner__c
LEFT JOIN 
    ENT.User_Salesforce u2 ON u2.Id = a.CSM_Owner2__c
LEFT JOIN 
    ENT.User_Salesforce u3 ON u3.Id = a.OwnerId

WHERE
    cws.ProdName__c LIKE '%ReadingEggs%' AND
    cws.Status__c LIKE '%Expired%' AND
    cws.License_Type__c IN ('Full','Extension') AND
    CAST(cws.End_Date__c AS DATE) >= CAST(DATEADD(month, -3, GETDATE()) AS DATE) AND
    CAST(cws.End_Date__c AS DATE) < CAST(DATEADD(day, 1, DATEADD(month, -3, GETDATE())) AS DATE) AND
    CAST(cws.Start_Date__c AS DATE) <= CAST(cws.End_Date__c AS DATE) AND
    a.Territory__c = 'EME' AND
    c.HasOptedOutOfEmail = 0 AND
    c.Is_Active__c = 'true' AND
    c.Status__c = 'Current' AND
    ((c.Title = '' OR c.Title = 'teacher' OR c.Title LIKE '%Subscription Coordinator%' OR c.Title LIKE '%admin%') OR 
    (rel.Roles ='Teacher' OR rel.Roles LIKE '%Subscription Coordinator%' OR rel.Roles LIKE '%admin%' OR rel.Roles LIKE '%Accounts Payable%')) AND
    c.Email IS NOT NULL AND
    rel.Product_Influencer__c LIKE '%ReadingEggs%' AND
    a.Name NOT LIKE '%Test%' AND 
    a.Name NOT LIKE '%fake%' AND 
    a.Name NOT LIKE '%inactive%' AND 
    a.Name NOT LIKE '%duplicate%'
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
    u.Name,
    a.CSM_Managed_Products__c,
    u2.Name,
    a.CSM_Managed_Products2__c,
    u3.Name,
    u3.Email,
    c.Title,
    rel.Roles,
    cws.Id,
    cws.Status__c,
    cws.License_Type__c
    