SELECT 
   stg.email,
   stg.[First Name],
   stg.[Last Name],
   stg.Title, 
   stg.District, 
   stg.Province, 
   stg.Country, 
   stg.[3PSeller],
   stg.SDRName, 
   stg.SDRTitle, 
   stg.SDREmail,
   CASE 
       WHEN contact.Id IS NOT NULL THEN contact.Id 
       ELSE stg.ContactID 
   END AS ContactID
FROM [AMER_RE0052_BacktoSchoolFY25_CAN_PRINCIPAL_1] stg
LEFT JOIN ENT.[Contact_Salesforce] contact 
    ON stg.[email] = contact.[Email]
