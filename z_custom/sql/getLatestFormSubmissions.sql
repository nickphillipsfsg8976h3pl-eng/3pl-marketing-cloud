select
    top 10 formname,
    firstname,
    lastname,
    email,
    submitteddata,
    submitteddate,
    isprocessed,
    leadidcreated,
    leadidupdated,
    resultstatus,
    errordetails
from
    lead_submission_queue
order by
    submitteddate desc