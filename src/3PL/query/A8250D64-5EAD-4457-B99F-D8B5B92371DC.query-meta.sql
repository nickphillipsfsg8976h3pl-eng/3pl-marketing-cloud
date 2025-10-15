SELECT
u.UserName,
u.Id as Id,
d.[First Name],
d.[Last Name],
d.[Work Email],
d.[Job Title]

FROM [Dynamic Sender Profile - AMER seller profiles] d
JOIN ent.[User_Salesforce] u ON u.Email=d.[Work Email]
