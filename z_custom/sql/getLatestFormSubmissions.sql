select
    top 100 
    formname,
    firstname,
    lastname,
    email,
    submitteddata,
    submitteddate,
    isprocessed,
    leadidcreated,
    leadidupdated,
    resultstatus,
    errordetails,
    retrievable
from
    lead_submission_queue
order by
    submitteddate desc