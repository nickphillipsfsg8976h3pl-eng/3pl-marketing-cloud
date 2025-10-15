SELECT TOP 800000
       sub.EmailAddress AS EmailAddress,
       s.jobId,
       j.journeyname AS JourneyName,
       s.SubscriberKey,
       s.eventdate AS EventDate,
       s.eventdate AT TIME ZONE 'Central Standard Time' AT TIME ZONE 'Aus Eastern Standard Time' AS EventDateAEST, 
       ja.activityname AS EmailName,
       ja.activityexternalkey AS ExternalKey
FROM   [CampaignMemberExclusion_BAU_Issue] de
       INNER JOIN ent._Subscribers sub on sub.SubscriberKey=de.LeadOrContactId
       INNER JOIN [_sent] s ON s.SubscriberKey = sub.SubscriberKey
       INNER JOIN [_journeyactivity] ja ON s.triggerersenddefinitionobjectid = ja.journeyactivityobjectid
       INNER JOIN [_journey] j ON ja.versionid = j.versionid
WHERE  
ja.activitytype IN ('EMAIL', 'EMAILV2') AND
s.eventdate >= '2025-05-14' 

GROUP  BY j.journeyname,
          s.eventdate,
          sub.EmailAddress,
          s.SubscriberKey,
          s.Jobid,
          ja.activityname,
          ja.activityexternalkey
ORDER BY s.SubscriberKey,s.eventdate DESC
