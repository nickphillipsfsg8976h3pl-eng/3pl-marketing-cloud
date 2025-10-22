SELECT 

    o.Id as OpportunityId,
    o.Type as OpportunityType,
    o.StageName as OpportunityStage,
    a.Name as AccountName,
    o.Current_Subscription_Start_Date__c as Current_Subscription_Start_Date__c,
    oppl.Id as OpportunityLineItemId,
    oppl.Product_Name__c,
    oppl.UnitPrice,
    oppl.TotalPrice,
    oppl.Actual_Quantity__c,
    CASE 
        WHEN o.Current_Subscription_Start_Date__c IS NOT NULL THEN DATEADD(year, 1, o.Current_Subscription_Start_Date__c)
        ELSE NULL
    END as One_Year_Subscription_End_Date,
    CASE 
        WHEN o.Current_Subscription_Start_Date__c IS NOT NULL THEN DATEADD(year, 2, o.Current_Subscription_Start_Date__c)
        ELSE NULL
    END as Two_Year_Subscription_End_Date,
    CASE 
        WHEN o.Current_Subscription_Start_Date__c IS NOT NULL THEN DATEADD(year, 3, o.Current_Subscription_Start_Date__c)
        ELSE NULL
    END as Three_Year_Subscription_End_Date,
    CASE 
        WHEN COUNT(*) OVER(PARTITION BY o.Id) > 1 THEN 1
        ELSE 0
    END as MultipleProducts,
    CASE
        WHEN o.StageName = 'Verbal Agreement' or o.StageName = 'Lost' or o.StageName = 'Sold - Contracted' or o.StageName = 'Deferred Decision' THEN 0
        ELSE 1
    END as isFormAccessible
FROM 
     ENT.Opportunity_Salesforce o
INNER JOIN 
    ENT.Account_Salesforce a ON o.AccountId = a.Id
INNER JOIN
    ENT.OpportunityLineItem_Salesforce oppl ON  oppl.OpportunityId = o.Id

WHERE 
o.Productlist__c LIKE '%Bright%' AND
oppl.Product_Name__c LIKE '%Bright%' AND
o.IsClosed = 0 AND
a.Name not LIKE '%Test%'