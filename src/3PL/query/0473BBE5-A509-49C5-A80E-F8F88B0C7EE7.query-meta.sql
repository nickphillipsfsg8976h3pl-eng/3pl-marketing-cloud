SELECT * 
FROM [Copy of AMER-Brochure-V4-Template]
WHERE DATEDIFF(minute, submissionDate, GETDATE()) <= 15
