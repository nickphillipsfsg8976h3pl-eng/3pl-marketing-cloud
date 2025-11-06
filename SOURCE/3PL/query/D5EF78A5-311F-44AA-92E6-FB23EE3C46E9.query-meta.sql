SELECT
   o.[Contact ID 18],
   s.[First Name],
   s.[Job Title],
   s.[Product Interest],
   o.Email,
   s.Country,
   s.Source
FROM [AMER_MS0031_HolidayResources Jan 16] o
JOIN [AMER_MS0031_HolidayResources Create] s ON o.[Contact ID 18]=s.[Contact ID 18]