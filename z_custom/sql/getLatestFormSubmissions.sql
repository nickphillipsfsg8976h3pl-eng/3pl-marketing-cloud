select
    top 10 SubmittedDate,
    FirstName,
    LastName,
    Email,
    SubmittedData
from
    Lead_Submission_Queue
where
    FirstName like '%Nick%'
order by
    SubmittedDate desc
