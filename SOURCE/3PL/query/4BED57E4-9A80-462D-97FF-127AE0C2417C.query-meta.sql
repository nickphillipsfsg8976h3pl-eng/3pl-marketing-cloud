SELECT
    SubscriberKey,
    AccountId,
    C3ID,
    [School Type],
    [School Category],
    [Account Name],
    [School Email],
    [AccountEmailOptOut],
    [Site Country],
    [BillingCountryCode],
    [Site State Province],
    [Territory__c],
    [Account owner full name],
    [UserName],
    [ESC contact number],
    [ESC email address],
    [ESC chili calendar link],
    ContactFirstName,
    ContactLastName,
    ContactEmail,
    ContactTitle,
    ContactJobFunction,
    ContactEmailOptOut,
    ContactRole,
    ContactType,
    OpportunityId
FROM (
    SELECT
        c.Id                             AS SubscriberKey,
        a.Id                             AS AccountId,
        a.C3_Id__c                       AS C3ID,
        a.School_Type__c                 AS [School Type],
        a.School_Category__c             AS [School Category],
        a.Name                           AS [Account Name],
        a.Email__c                       AS [School Email],
        a.Email_Opt_Out__c               AS [AccountEmailOptOut],
        a.BillingCountry                 AS [Site Country],
        a.BillingCountryCode             AS [BillingCountryCode],
        a.BillingState                   AS [Site State Province],
        a.Territory__c                   AS [Territory__c],
        u.Name                           AS [Account owner full name],
            u.UserName as UserName,
    u.ESC_Contact_Number__c as [ESC contact number],
    u.Email as [ESC email address],
    u.ESC_chili_calendar_link__c as [ESC chili calendar link],

        c.FirstName                      AS ContactFirstName,
        c.LastName                       AS ContactLastName,
        c.Email                          AS ContactEmail,
        c.Title                          AS ContactTitle,
        c.Job_Function__c                AS ContactJobFunction,
        c.HasOptedOutOfEmail             AS ContactEmailOptOut,

        ocr.Role                         AS ContactRole,
        CASE WHEN ocr.IsPrimary = 1 
             THEN 'Primary Opportunity Contact' 
             ELSE 'Opportunity Contact' 
        END                              AS ContactType,

        r.OpportunityId                  AS OpportunityId,

        ROW_NUMBER() OVER (
            PARTITION BY r.OpportunityId
            ORDER BY CASE WHEN ocr.IsPrimary = 1 THEN 1 ELSE 2 END,
                     ocr.Id
        ) AS rn

    FROM [Renewal Opportunity - LookUp Table_Including3E_Email4] r
    INNER JOIN ENT.Account_Salesforce a
            ON r.AccountID = a.Id
    INNER JOIN ENT.OpportunityContactRole_Salesforce ocr
            ON ocr.OpportunityId = r.OpportunityId
           AND ocr.Role = 'Opportunity Contact'
    INNER JOIN ENT.Contact_Salesforce c
            ON c.Id = ocr.ContactId
    LEFT  JOIN ENT.User_Salesforce u
            ON u.Id = a.OwnerId
    WHERE
        c.HasOptedOutOfEmail = 0
        AND c.Is_Active__c   = 'true'
        AND c.Status__c      = 'Current'
        AND c.Email IS NOT NULL
        AND a.Territory__c   = 'APAC'
        AND a.BillingCountryCode IN ('NZ') 
        AND a.Name NOT LIKE '%fake%'
        AND a.Name NOT LIKE '%inactive%'
        AND a.Name NOT LIKE '%duplicate%'
        AND c.RecordTypeID   != '0120I000000pp8lQAA'
        AND a.RecordTypeID   != '0120I0000019ZejQAE'
) t
WHERE rn = 1
