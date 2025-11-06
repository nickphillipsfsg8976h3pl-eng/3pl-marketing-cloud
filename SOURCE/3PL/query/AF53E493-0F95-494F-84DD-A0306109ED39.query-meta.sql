SELECT 
    stg.[first name] as [first name],
    stg.[email] as [email],
    latestLead.[Contact ID 18],
    stg.[Job Title],
    stg.[Product Interest],
    stg.Country,
    stg.Source
FROM [AMER_RE0024_HolidayResources Create - Staging] stg
INNER JOIN (
    SELECT 
        contact.[Email],
        contact.Id as [Contact ID 18],
        ROW_NUMBER() OVER (PARTITION BY contact.[Email] ORDER BY contact.[CreatedDate] DESC) as rn
    FROM ENT.[Lead_Salesforce] contact
    WHERE contact.IsConverted = 0
) latestLead ON stg.[email] = latestLead.[Email] AND latestLead.rn = 1
 AND NOT EXISTS (SELECT a.Email FROM [AMER_RE0024_HolidayResources] a where a.[email]= stg.[email]) 