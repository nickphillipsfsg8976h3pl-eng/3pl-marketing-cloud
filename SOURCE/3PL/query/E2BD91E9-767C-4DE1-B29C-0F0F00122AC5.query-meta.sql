SELECT 
    Distinct c.Id as ContactKey,
    c.Email,
    c.AccountId, 
    a.Name as AccountName,
    o.Id as OpportunityId,
    o.StageName as OpportunityStage
FROM 
     ENT.Opportunity_Salesforce o
INNER JOIN 
    ENT.Account_Salesforce a ON o.AccountId = a.Id
INNER JOIN
    ENT.AccountContactRelation_Salesforce rel ON  a.Id = rel.AccountId 
INNER JOIN
    ENT.Contact_Salesforce c ON  rel.ContactId = c.Id
WHERE 
    o.IsClosed = 0 AND
    c.Email is not null