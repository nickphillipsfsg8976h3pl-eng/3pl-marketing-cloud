SELECT [Site Country], [Contact ID 18], [First Name Proper], [Last Name Proper], Email, [Job Title], [Product Interest], [NB or CC], Source
FROM [AMER_3P0029-EdChat-April222024 Promo 1] a
WHERE
NOT EXISTS (SELECT 1 FROM
            [AMER_3P0029_Exclusion] b WHERE b.Email=a.Email)