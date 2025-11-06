SELECT TOP 5000 *
FROM [000_Lead_Submission_Queue_LAST_3DAYS]
WHERE
    (ErrorCode = 'TEST_KEYWORDS' OR ErrorCode = 'PERSONAL_EMAIL_DOMAIN' OR ErrorCode IS NULL) AND
    IsProcessed      = 0
ORDER BY SubmittedDate DESC