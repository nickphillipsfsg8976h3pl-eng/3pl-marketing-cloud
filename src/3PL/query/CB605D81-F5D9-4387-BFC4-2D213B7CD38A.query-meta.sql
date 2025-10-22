SELECT TOP 5000 *
FROM Lead_Submission_Queue
WHERE
    SubmittedDate    >= DATEADD(DAY, -20, GETDATE()) AND
    IsProcessed      = 0 AND
    SubmittedData IS NOT NULL
ORDER BY SubmittedDate DESC