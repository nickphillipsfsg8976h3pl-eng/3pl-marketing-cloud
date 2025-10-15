SELECT

  fs.SubscriberKey,
  fs.EmailAddress,
  fs.SubscriberType,
  fs.Status,
  fs.DateJoined,
  MAX(s.EventDate) AS LastEventDate,
  s.JobID as JobId,
  j.EmailName,
  j.EmailSubject
FROM ContactAnalytisB2B fs
INNER JOIN ent._Sent s on s.SubscriberKey = fs.SubscriberKey
INNER JOIN _Job j on j.JobId = s.JobId

Group BY fs.SubscriberKey,s.JobID,j.EmailName,j.EmailSubject,  fs.EmailAddress,  
  fs.SubscriberType,
  fs.Status,
  fs.DateJoined
