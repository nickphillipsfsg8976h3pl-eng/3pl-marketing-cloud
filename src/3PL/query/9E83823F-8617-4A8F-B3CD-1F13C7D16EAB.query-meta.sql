SELECT
    DISTINCT 
    c.Id as ContactID18,
    c.FirstName ,
    c.LastName,
    c.Email as EmailAddress,
    c.Title as ContactTitle,
    c.Job_Function__c as JobFunction,
    c.HasOptedOutOfEmail,
    c.Status__c,
    rel.roles as ContactRoles,
    a.Id as AccountID18,
    a.Name as SchoolName,
    a.BillingStateCode as State,
    acc.SellerEmail as SellerEmail,
    acc.SellerName as SellerName,
    acc.SellerPhone as SellerPhone

FROM ENT.Contact_Salesforce c
INNER JOIN ENT.AccountContactRelation_Salesforce rel
    ON c.Id = rel.ContactId
INNER JOIN ENT.Account_Salesforce a
    ON rel.AccountId = a.Id
INNER JOIN (
    SELECT DISTINCT AccountID18, SellerEmail,SellerName,SellerPhone
    FROM [APAC_3P0066_BTS_3E_Marketing_Email_DE_DecisionMakers]
) acc ON acc.AccountID18 = a.Id
LEFT JOIN [APAC_3P0066_BTS_3E_Marketing_Email_DE_DecisionMakers] ex
    ON ex.ContactID18 = c.Id
INNER JOIN
    ENT.User_Salesforce u
        ON a.OwnerId = u.Id
WHERE
    ex.ContactID18 IS NULL AND
    c.HasOptedOutOfEmail = 0 AND
    c.Is_Active__c = 'true' AND
    c.Email IS NOT NULL AND
    ((c.Title IS NULL AND c.Job_Function__c IS NULL AND rel.roles IS NULL)
    OR(LOWER(c.Title) LIKE '%teacher%' 
     OR LOWER(c.Job_Function__c) LIKE '%teacher%' 
     OR LOWER(rel.roles) LIKE '%teacher%'))
