SELECT
u.UserName,
u.Id as Id,
u.[FirstName] as [First Name],
u.[LastName] as [Last Name],
d.[Work Email],
d.[Job Title]

FROM [Dynamic Sender Profile - EMEA seller profiles] d
JOIN ent.[User_Salesforce] u ON u.Email=d.[Work Email]
