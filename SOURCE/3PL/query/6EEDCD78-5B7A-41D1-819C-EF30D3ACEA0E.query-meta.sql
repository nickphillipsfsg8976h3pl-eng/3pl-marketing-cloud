SELECT
c.ContactKey,
c.FirstName,
c.LastName,
c.[EmailAddr - CRM],
c.[EmailAddr - All subscribers],
c.[LogDate] as [ProcessedDate]
FROM [Email Address Change - Staging] c
