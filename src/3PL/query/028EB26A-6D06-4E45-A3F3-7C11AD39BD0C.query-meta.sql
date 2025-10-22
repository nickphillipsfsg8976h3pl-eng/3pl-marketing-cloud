SELECT TOP 50000
    cws.Id AS [CampaignMember:Id],
    cws.CampaignId AS [CampaignMember:CampaignId],
    cws.City AS [CampaignMember:City],
    cws.CompanyOrAccount AS [CampaignMember:CompanyOrAccount],
    cws.ContactId AS [CampaignMember:ContactId],
    cws.Country AS [CampaignMember:Country],
    cws.CreatedById AS [CampaignMember:CreatedById],
    cws.CreatedDate AS [CampaignMember:CreatedDate],
    cws.Email AS [CampaignMember:Email],
    cws.HasOptedOutOfEmail AS [CampaignMember:HasOptedOutOfEmail],
    cws.FirstName AS [CampaignMember:FirstName],
    cws.Title AS [CampaignMember:Title],
    cws.LastName AS [CampaignMember:LastName],
    cws.LeadId AS [CampaignMember:LeadId],
    cws.State AS [CampaignMember:State],
    cws.UTM_Campaign__c AS [CampaignMember:UTM_Campaign__c],
    cws.UTM_Content__c AS [CampaignMember:UTM_Content__c],
    cws.UTM_Medium__c AS [CampaignMember:UTM_Medium__c],
    cws.UTM_Source__c AS [CampaignMember:UTM_Source__c],
    cws.UTM_Term__c AS [CampaignMember:UTM_Term__c],
    cws.PostalCode AS [CampaignMember:PostalCode],

    cws.Id AS [CampaignMember:Common:Id],
    cws.Email AS [CampaignMember:Common:Email],
    cws.HasOptedOutOfEmail AS [CampaignMember:Common:HasOptedOutOfEmail],
 
    cws.FirstName AS [CampaignMember:Common:FirstName],
    cws.Name AS [CampaignMember:Common:Name],
    lead.Job_Function__c AS [CampaignMember:Common:Job_Function__c],
    cws.Title AS [CampaignMember:Common:Title],
    cws.LastName AS [CampaignMember:Common:LastName],
 
    cws.UTM_Campaign__c AS [CampaignMember:Common:UTM_Campaign__c],
    cws.UTM_Content__c AS [CampaignMember:Common:UTM_Content__c],
    cws.UTM_Medium__c AS [CampaignMember:Common:UTM_Medium__c],
    cws.UTM_Source__c AS [CampaignMember:Common:UTM_Source__c],
    cws.UTM_Term__c AS [CampaignMember:Common:UTM_Term__c],

    camp.School_Type__c AS [CampaignMember:Campaign:School_Type__c],
    camp.Id AS [CampaignMember:Campaign:Id],

    lead.Campaign_Code__c AS [CampaignMember:Lead:Campaign_Code__c],
    lead.Campaign_Name__c AS [CampaignMember:Lead:Campaign_Name__c],
    lead.City AS [CampaignMember:Lead:City],
    lead.Country AS [CampaignMember:Lead:Country],
    lead.Country__c AS [CampaignMember:Lead:Country__c],
    lead.CountryCode AS [CampaignMember:Lead:CountryCode],

    lead.RecordTypeId AS MemberRecordType

FROM ENT.[CampaignMember_Salesforce] cws
INNER JOIN ENT.[Lead_Salesforce] lead 
    ON lead.Id = cws.LeadId
INNER JOIN ENT.[Campaign_Salesforce] camp 
    ON camp.Id = cws.CampaignId


WHERE 
    cws.CampaignId IN (
        '701Mp00000W1DFJIA3'
    )
    AND cws.[Email] NOT IN (
        SELECT ex.[CampaignMember:Email]
 
        FROM [AMER_3P0069_DA_Strong_Foundation_Nurture - 2025-02-25T100743236] ex 
    )
ORDER BY cws.CreatedDate DESC
