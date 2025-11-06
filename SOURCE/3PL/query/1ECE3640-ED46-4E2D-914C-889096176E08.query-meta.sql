SELECT TOP 1
    sr.IPAddress,
    sr.EmailAddress,
    v.VoucherID,
    v.ChallengeCode,
    v.VoucherURL
FROM [SurveyResponsesDE] sr
LEFT JOIN [VoucherDE] v ON v.IsAssigned = 'false'
WHERE sr.IPAddress NOT IN (SELECT IPAddress FROM [AssignedVouchersDE])
ORDER BY sr.DateSubmitted ASC
