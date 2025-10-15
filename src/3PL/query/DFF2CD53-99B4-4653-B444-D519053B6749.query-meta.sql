select
s.emailaddress
, s.subscriberkey
, s.SubscriberType
, s.status
, s.datejoined
from ent._subscribers s
where s.dateJoined >= DATEADD(month, -4, GETDATE())
AND
s.subscriberkey not like '00%' and s.subscriberkey not like 'BEL%' and s.subscriberkey not like 'RE-%'