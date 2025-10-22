select
*

from [APAC_RE_NB_Campaign_AU_NZ_SA_GENERIC_AUDIENCE_DEDUPED] a

where 
Not exists ( SELECT ContactId from [APAC_RE0146_SoR_Whitepaper_E1_Sent] b where b.ContactId=a.ContactKey)