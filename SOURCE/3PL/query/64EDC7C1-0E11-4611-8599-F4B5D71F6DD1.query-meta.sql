SELECT
    c.Id AS [Contact ID 18],
    cws.ProdName__c,
    cws.Start_Date__c,
    cws.End_Date__c,
    a.Name AS [Account Name],
    a.BillingCountry AS [Site Country],
    a.Territory__c AS Territory,
    a.Id AS [Account ID 18],
    c.Email,
    c.FirstName AS [First Name],
    c.LastName AS [Last Name],
    MAX(o.CloseDate) AS LatestCloseDate,
    a.CSM_Owner__c,
    a.CSM_Owner2__c,
    u.Name AS [CSM Owner1 Name],
    a.CSM_Managed_Products__c AS [CSM Managed Products1],
    u2.Name AS [CSM Owner2 Name],
    a.CSM_Managed_Products2__c AS [CSM Managed Products2],
    u3.Name AS [Account Owner],
    u3.Email AS [Account Owner Email]

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
    cws.ProdName__c LIKE '%Mathletics%' AND
    cws.Status__c LIKE '%Lost%' AND
    cws.Start_Date__c > DATEADD(month, -2, GETDATE()) AND
    cws.End_Date__c > DATEADD(day, 0, GETDATE()) AND
    c.Territory__c LIKE '%%EMEA%%'AND
    c.HasOptedOutOfEmail = 0 AND
    c.Is_Active__c = 'False' AND
    c.Status__c = 'Current' AND
    (
        c.Title = 'teacher' OR 
        c.Title LIKE '%Subscription Coordinator%' OR 
        c.Title LIKE '%admin%'
    ) AND 
    rel.Product_Influencer__c LIKE '%Mathletics%' AND
    c.Email IS NOT NULL AND
    (
        a.Name NOT LIKE '%Test%' AND
        a.Name NOT LIKE '%fake%' AND
        a.Name NOT LIKE '%inactive%' AND
        a.Name NOT LIKE '%duplicate%'
    ) AND
    (o.Type = 'Renewal' OR
    o.Type = 'New Business') AND
    o.Productlist__c LIKE '%Mathletics%' AND
    o.StageName = 'Lost' AND
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
    u.Name,
    a.CSM_Managed_Products__c,
    u2.Name,
    a.CSM_Managed_Products2__c,
    u3.Name,
    u3.Email,
    o.closedate
