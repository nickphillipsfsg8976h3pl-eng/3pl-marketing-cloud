select
j.JourneyName as JourneyName ,
j.VersionNumber as Version,
ja.ActivityName as EmailName,
s.EventDate as SendDate,
s.SubscriberKey as ContactID,
s.JobID as JoBID,
s.ListID as ListID,
s.BatchID as BatchID

from [_Job] job
inner join [_Sent] s ON job.JobId=s.jobid

inner join [_JourneyActivity] ja on s.TriggererSendDefinitionObjectID = ja.JourneyActivityObjectID
inner join [_Journey] j on ja.VersionID = j.VersionID

where ja.ActivityType in  ('EMAIL','EMAILV2')
and j.JourneyName = 'APAC_RE0146_SoR_Whitepaper'
and ja.ActivityName= 'APAC_RE0146_SoR_Whitepaper_E1'
and s.EventDate > dateadd(d,-30,getdate())
and job.JobId = '1259655'