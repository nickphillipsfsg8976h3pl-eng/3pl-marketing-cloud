SELECT s.EmailAddress AS [Email Address] 
FROM ENT._Subscribers s
WHERE SUBSTRING(s.EmailAddress, CHARINDEX('@', s.EmailAddress) + 1, LEN(s.EmailAddress)) 
      IN ('tsc.k12.in.us','ocsb.ca','ldcsb.ca','gscs.ca','pvsd.ca','cssd.ab.ca','learn.cssd.ab.ca','ncds.on.ca','wesdschools.org','cbe.ab.ca') AND
      s.EmailAddress !='darms@tsc.k12.in.us'
      AND s.DateJoined >= DATEADD(day, -1, GETDATE()) 

UNION

SELECT c.Email AS [Email Address] 
FROM ENT.Contact_Salesforce c
WHERE SUBSTRING(c.Email, CHARINDEX('@', c.Email) + 1, LEN(c.Email)) 
      IN ('tsc.k12.in.us','ocsb.ca','ldcsb.ca','gscs.ca','pvsd.ca','cssd.ab.ca','learn.cssd.ab.ca','ncds.on.ca','wesdschools.org','cbe.ab.ca') AND
      c.Email !='darms@tsc.k12.in.us'
      AND (c.CreatedDate >= DATEADD(day, -1, GETDATE()) OR c.LastModifiedDate >= DATEADD(day, -1, GETDATE()))

UNION

SELECT l.Email AS [Email Address] 
FROM ENT.Lead_Salesforce l
WHERE SUBSTRING(l.Email, CHARINDEX('@', l.Email) + 1, LEN(l.Email)) 
      IN ('tsc.k12.in.us','ocsb.ca','ldcsb.ca','gscs.ca','pvsd.ca','cssd.ab.ca','learn.cssd.ab.ca','ncds.on.ca','wesdschools.org','cbe.ab.ca') AND
      l.Email !='darms@tsc.k12.in.us'
AND (l.CreatedDate >= DATEADD(day, -1, GETDATE()) OR l.LastModifiedDate >= DATEADD(day, -1, GETDATE()))
