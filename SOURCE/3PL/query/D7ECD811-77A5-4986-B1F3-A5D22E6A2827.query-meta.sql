SELECT
  o.Id AS OpportunityId,
  o.Type,
  o.StageName,
  o.Productlist__c,
  o.AccountId,
  o.CloseDate

FROM
  ENT.Opportunity_Salesforce o
WHERE
  o.Productlist__c LIKE '%3 Essentials%'
  AND o.StageName = 'Lost' 
  AND o.Won_Lost_Reason__c != 'Duplicate/op error'
  AND o.CloseDate >= '2025-02-01'
  AND o.CloseDate < '2025-05-10'
  