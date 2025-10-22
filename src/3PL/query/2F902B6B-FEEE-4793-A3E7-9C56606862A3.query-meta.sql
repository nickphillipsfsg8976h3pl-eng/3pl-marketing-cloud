SELECT
    t.[Teacher First Name] as [FirstName], 
    t.[Teacher Last Name], 
    t.[Teacher Email], 
    t.[School ID], 
    t.[School Code], 
    t.[School Name], 
    t.[Number of Students], 
    t.[School Country] as [Country], 
    t.[School Town], 
    t.[School Postcode], 
    t.[School State], 
    t.[District Code], 
    t.[District Name], 
    t.[Trial End Date], 
    t.[Trial Start Date], 
    t.[Teacher Trial Subscription ID]
FROM [RE3P_Automated_Teacher_Trials_TargetData] t
/* WHERE 
    t.[Teacher Email] != 'testing@mail.com'*/