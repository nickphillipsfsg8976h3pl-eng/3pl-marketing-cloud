-- STEP 1
-- OVERWRITE [Renewal Opportunity - LookUp Table_Excluding3E_Email4]

SELECT TOP 50000
    a.Id                                AS AccountId,
    o.Id                                AS OpportunityId,
    r.Name                              AS AccountRecordType,
    a.Name                              AS AccountName,
    a.Account_Segment__c,
    a.Territory__c,
    a.BillingCountryCode,
    o.Type                              AS OpportunityType,
    o.StageName                         AS OpportunityStage,
    o.Survey_Gizmo_Form_Link__c         AS Renewal_Form_Link__c,
    o.[Exclude_From_EBS__c],
    o.Signed_contract_received__c,
    o.SBQQ__AmendedContract__c,
    o.Productlist__c,
    o.Number_of_years__c,
    o.Renewed_Contract_End_Date__c      AS [Renewed Contract End Date],
    o.ProductList_Gong__c

FROM ENT.Opportunity_Salesforce o
INNER JOIN ENT.Account_Salesforce a ON o.AccountID = a.Id
INNER JOIN ENT.RecordType_Salesforce r ON r.Id = a.RecordTypeId

WHERE
    o.StageName IN ('Discovery','Evaluation','Negotiation')
    AND o.Renewed_Contract_End_Date__c >= '2025-09-01'
    AND o.Renewed_Contract_End_Date__c <= '2026-03-31'
    AND o.Type = 'Renewal'
    AND o.Productlist__c LIKE '%3 Essentials Package%'
    AND o.Productlist__c NOT LIKE '%Brightpath%'
    AND o.Productlist__c NOT LIKE '%Wordflyers%'

    AND o.Survey_Gizmo_Form_Link__c LIKE '%https://%'
    AND (o.[Exclude_From_EBS__c] IS NULL OR o.[Exclude_From_EBS__c] = '' OR o.[Exclude_From_EBS__c] = 0)
    AND (o.Signed_contract_received__c IS NULL OR o.Signed_contract_received__c ='' or o.Signed_contract_received__c != 'Yes')
    AND (o.SBQQ__AmendedContract__c IS NULL OR o.SBQQ__AmendedContract__c = '')
    AND (o.Number_of_years__c IS NULL OR o.Number_of_years__c ='' OR o.Number_of_years__c='1')                        /*Exclude MultiYear Opps*/
    AND o.Amount > 0                                                                      /*Exclude Charity,Compl*/
    /*AND (a.Account_Segment__c IS NULL OR a.Account_Segment__c ='' OR a.Account_Segment__c !='House Account FY26')*/
    AND a.RecordTypeId !='012280000001tRBAAY'  /*Exclude Cluster Accounts*/
    AND o.SBQQ__PrimaryQuote__c is not null
    AND o.SBQQ__RenewedContract__c is not null
    AND a.Territory__c = 'APAC'
    AND a.BillingCountryCode IN ('AU','NZ')
    AND a.isTestAccount__c = 0
ORDER BY ACCOUNTID
