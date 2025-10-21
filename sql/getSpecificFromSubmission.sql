select
    top 10 SubmittedDate,
    FirstName,
    LastName,
    Email,
    SubmittedData
from
    Lead_Submission_Queue
where
    Email LIKE '%test@test.com%'
order by
    SubmittedDate desc
