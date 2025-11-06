SELECT 
[Contact ID 18], Email, [First Name], [Last Name], Title, State, Country, [Account Name]
FROM
AMER_3P0044_EdChat_Jan25_EM1 a
WHERE
NOT Exists (SELECT Email from [EdChat Jan25 Registrants - Week1] b where b.Email=a.Email)