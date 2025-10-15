SELECT DISTINCT
  a.Name AS [School Name],
  a.BillingCountryCode AS [Country Code],
  a.BillingStateCode AS [State Code],
  'true' AS IsActive
FROM ENT.Account_Salesforce a
WHERE
  a.Name IS NOT NULL
  AND a.BillingCountryCode IS NOT NULL
  AND a.BillingStateCode IS NOT NULL

 